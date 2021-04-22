<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use App\Traits\HelperTrait as AppHelper;
use App\Models\DogVaccination;
use App\Models\DogBreed;
use App\Models\DogCard;
use Carbon\Carbon;
use Helper;
use Image;
use QrCode;
use DNS1D;

class AppController extends Controller
{
    use AppHelper;

    public function allBreeds(Request $request)
    {
        $responseArr = [];
        $allBreeds = DogBreed::orderBy('name', 'asc');
        if ($request->has('status') && is_array($request->get('status')) && !empty($request->get('status'))) {
            $allBreeds = $allBreeds->whereIn('status', $request->get('status'));
        }
        if ($request->has('pagination') && $request->get('pagination') != '' && $request->get('pagination') != 0) {
            $allBreeds = $allBreeds->paginate($request->get('pagination'));
        } else {
            $allBreeds = $allBreeds->get();
        }
        $responseArr['status'] = 200;
        $responseArr['type'] = 'success';
        $responseArr['msg'] = 'All Dog Breeds';
        $responseArr['content'] = [
            'dogBreeds' => $allBreeds
        ];
        return response()->json($responseArr, 200);
    }

    public function allVaccination(Request $request)
    {
        $responseArr = [];
        $vaccination = DogVaccination::orderBy('name', 'asc');
        if ($request->has('status') && is_array($request->get('status')) && !empty($request->get('status'))) {
            $vaccination = $vaccination->whereIn('status', $request->get('status'));
        }
        if ($request->has('pagination') && $request->get('pagination') != '' && $request->get('pagination') != 0) {
            $vaccination = $vaccination->paginate($request->get('pagination'));
        } else {
            $vaccination = $vaccination->get();
        }
        $responseArr['status'] = 200;
        $responseArr['type'] = 'success';
        $responseArr['msg'] = 'All Dog Vaccination';
        $responseArr['content'] = [
            'dogVaccination' => $vaccination
        ];
        return response()->json($responseArr, 200);
    }

    public function createDogDigitalCard(Request $request)
    {
        $rules = [
            'name' => ['bail', 'required', 'min:3'],
            'dog_breed_id' => ['required'],
            'date_of_birth' => ['required'],
            'gender' => ['required'],
            'owner_name' => ['bail', 'required', 'min:3'],
            'owner_contact_number' => ['bail', 'required', 'digits_between:10,12'],
            'dog_image' => ['bail', 'required', 'image', 'mimes:jpeg,jpg,png', 'dimensions:min_width=300,min_height=180', 'max:5048'],
            'living_address' => ['bail', 'required'],
        ];
        $messages = [
            'name.required' => 'Dog name is required.',
            'name.min' => 'Dog name required minimum 3 characters.',
            'dog_breed_id.required' => 'Dog breed is required.',
            'date_of_birth.required' => 'Dog date of birth is required.',
            'gender.required' => 'Dog gender is required.',
            'owner_name.required' => 'Dog owner name is required.',
            'owner_name.min' => 'Dog owner name required minimum 3 characters.',
            'owner_contact_number.required' => 'Dog owner contact number is required.',
            'owner_contact_number.digits_between' => 'Dog owner contact number is invalid.',
            'dog_image.required' => 'Dog image is required.',
            'dog_image.mimes' => 'Dog image extension incorrect.',
            'dog_image.dimensions' => 'Dog image required minimum [300x180].',
            'dog_image.max' => 'Maximum image size 4mb',
            'living_address.required' => 'Dog living address is required',
        ];
        $validation = $this->checkInputValidation($request->all(), $rules, $messages);
        if (!empty($validation)) {
            return response()->json($validation, $validation['status']);
        }
        
        $maxId = DogCard::max('id');
        $cardNumber = Helper::uniqueCardNumber($maxId + 1);
        $dogCard = new DogCard;
        $dogCard->card_number = $cardNumber;
        $dogCard->name = strtoupper($request->input('name'));
        $dogCard->dog_breed_id = $request->input('dog_breed_id');
        $dogCard->date_of_birth = Carbon::parse($request->input('date_of_birth'))->format('Y-m-d');
        $dogCard->gender = $request->input('gender');
        $dogCard->owner_name = ucwords($request->input('owner_name'));
        $dogCard->owner_contact_number = $request->input('owner_contact_number');
        $dogCard->living_address = $request->input('living_address');
        $dogCard->vaccination_info = $request->input('vaccination_info');

        if  ($request->hasFile('dog_image')) {
            $img = $request->file('dog_image');
            $real_path = $img->getRealPath();
            $file_orgname = $img->getClientOriginalName();
            $file_size = $img->getSize();
            $file_ext = strtolower($img->getClientOriginalExtension());
            $file_newname = $cardNumber . "." . $file_ext;

            $destinationPath = public_path('uploads');
            $thumb_path = $destinationPath."/thumbs";
            $small_path = $destinationPath."/smalls";
            
            $imageResize = false;
            if ($file_ext == 'jpeg' || $file_ext == 'jpg') {
                $imgObj = Image::make(imagecreatefromjpeg($img));
                $imageResize = true;
            } elseif ($file_ext == 'png') {
                $imgObj = Image::make(imagecreatefrompng($img));
                $imageResize = true;
            } else {
                $img->move($thumb_path, $file_newname);
            }
            
            if ($imageResize) {
                $imgObj->resize(300, NULL, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumb_path . '/' . $file_newname);
                
                $imgObj->resize(150, NULL, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($small_path . '/' . $file_newname);
            }
            //$imgObj->resize(100, 100)->save($thumb_path . '/100/' . $file_newname);

            // $img->move($destinationPath, $file_newname);
            $dogCard->dog_image = $file_newname;
        }

        $dogCard->save();

        $this->qrcodeGenerate($dogCard);
        $this->barcodeGenerate($dogCard);

        $responseArr = [];
        $responseArr['status'] = 200;
        $responseArr['type'] = 'success';
        $responseArr['msg'] = 'Card has been created successfully, thankyou.';
        $responseArr['content'] = [
            'cardInfo' => $dogCard
        ];
        return response()->json($responseArr, 200);
    }

    public function qrcodeGenerate($cardObj)
    {
        $qrCodeData = 'Name:' . $cardObj->name . ', ';
        $qrCodeData .= 'Breed:' . $cardObj->dogBreed->name . ', ';
        $qrCodeData .= 'Owner:' . $cardObj->owner_name . ' (' . $cardObj->owner_contact_number . '), ';
        $qrCodeData .= 'vaccination:' . str_replace(',' , ', ' , $cardObj->vaccination_info) . '.';
        $qrCodeSavePath = public_path('uploads/qrcodes/' . $cardObj->card_number . '.svg');
        $image = QrCode::eyeColor(0, 255, 70, 64, 0, 0, 0)->format('svg')->size(300)->generate($qrCodeData, $qrCodeSavePath);
    }

    public function barcodeGenerate($cardObj)
    {
        $savePath = 'uploads/barcodes/' . $cardObj->card_number . '.svg';
        File::put(public_path($savePath), DNS1D::getBarcodeSVG($cardObj->card_number, 'C39+', 3, 33, '#dcff73', true));
        // $barcodeImage = 'data:image/png;base64,' . DNS1D::getBarcodePNG($cardObj->card_number, 'C39+', 3, 33, array(235, 232, 52), true);
    }

    public function showDogDigitalCard(Request $request, $cardNumber)
    {
        $responseArr = [];
        $responseArr['status'] = 404;
        $dogCard = DogCard::where('card_number', $cardNumber)->where('status', 1)->first();
        if (!empty($dogCard)) {
            $responseArr['status'] = 200;
            $responseArr['type'] = 'success';
            $responseArr['msg'] = 'Card Details';
            $responseArr['content'] = [
                'cardDetails' => $dogCard,
                'breedInfo' => $dogCard->dogBreed
            ];
        }
        return response()->json($responseArr, $responseArr['status']);
    }

    public function saveCardImage(Request $request, $cardNumber)
    {
        $responseArr = [];
        $responseArr['status'] = 200;

        $dogCard = DogCard::where('card_number', $cardNumber)->first();
        if (empty($dogCard)) {
            $responseArr['type'] = 'error';
            $responseArr['msg'] = 'Something went wrong, try again.';
            $responseArr['content'] = [];
        }
        $dogCard->card_image = $request->input('card_image');
        $dogCard->save();

        $responseArr['type'] = 'success';
        $responseArr['msg'] = 'Card generated successfully. Please download, thankyou.';
        $responseArr['content'] = [
            'card' => $dogCard
        ];
        return response()->json($responseArr, 200);
    }
}
