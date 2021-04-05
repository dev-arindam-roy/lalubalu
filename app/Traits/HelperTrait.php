<?php

namespace App\Traits;
use Validator;
use Log;
use DB;

trait HelperTrait {

    public function checkInputValidation($formData, $rules, $messages)
    {
        $responseArr = [];
        $validation = Validator::make($formData, $rules, $messages);
        if ($validation->fails()) {
            $responseArr['status'] = 422;
            $responseArr['type'] = 'fieldValidationError';
            $responseArr['msg'] = 'Validation Errors';
            $validationErrors = $validation->errors();
            $validationErrorsArr = $validation->errors()->toArray();
            $errors = [];
            foreach($validationErrorsArr as $errs) {
                foreach($errs as $err) {
                    array_push($errors, $err);
                }
            }
            $responseArr['content'] = [
                'validationErrors' => $errors
            ];
        }
        return $responseArr;
    }
}