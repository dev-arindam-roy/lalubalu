<template>
    <div id="quckCreateDigitalCard" class="mt-3 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <h1 class="theme-green-primary-color text-center"><i class="fas fa-dog fa-2x theme-dark-green-primary-color"></i><br/><strong>Digital Card For Your Dog</strong></h1>
                    <form @submit.prevent="createCardSubmit">
                        <div class="card">
                            <div class="card-header card-primary-header text-center">Just enter all details & download the digital card</div>
                            <div class="card-body">
                                <div id="serverValidationBlock">
                                    <validationErrorComponent :validationErrorListArr="validationErrors" class="mb-1"></validationErrorComponent>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Dog Name: <em>*</em></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-dog"></i></span>
                                                </div>
                                                <input type="text" v-model.trim="cardData.dogName" class="form-control" placeholder="Your Dog Name">
                                            </div>
                                            <div class="text-danger" v-if="!$v.cardData.dogName.required && $v.cardData.dogName.$error">Please enter your dog name.</div>
                                            <div class="text-danger" v-if="!$v.cardData.dogName.minLength && $v.cardData.dogName.required && $v.cardData.dogName.$error">Minimum 3 characters required.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Dog Breed: <em>*</em></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-paw"></i></span>
                                                </div>
                                                <select v-model.trim="cardData.dogBreed" class="form-control">
                                                    <option value="" selected disabled>Select Your Dog Breed</option>
                                                    <option v-for="item in dogBreedList"  v-bind:key="item.id" v-bind:value="item.id">{{item.name}}</option>
                                                </select>
                                            </div>
                                            <div class="text-danger" v-if="!$v.cardData.dogBreed.required && $v.cardData.dogBreed.$error">Please select your dog breed.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Dog Photo: <em>*</em></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-image"></i></span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" ref="dogPhoto" accept="image/*" class="custom-file-input" id="inputGroupFile01" v-on:change="handleDogImgUploads($event)">
                                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                </div>
                                            </div>
                                            <div class="text-danger" v-if="!isDogImageSelected">Please select your dog image.</div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <img :src="displayDogImage" class="img-fluid img-thumbnail rounded dog-default-image">
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="text-danger" v-if="!isDogImgExtValid">Image extension is wrong.</div>
                                                <div class="text-danger" v-if="!isDogImgSizeValid && isDogImgExtValid">Image size is should less than 2mb.</div>
                                                <button type="button" v-show="isDogImgHasError" class="btn btn-sm btn-danger" v-on:click="resetDogImage">Reset</button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Dog Gender: <em>*</em></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-bone"></i></span>
                                                </div>
                                                <select v-model.trim="cardData.dogGender" class="form-control">
                                                    <option value="" selected disabled>Select Your Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                            <div class="text-danger" v-if="!$v.cardData.dogGender.required && $v.cardData.dogGender.$error">Please select your dog gender.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Date of Birth: <em>*</em></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <date-picker v-model.trim="cardData.dogDob" :config="dateOptions" class="form-control" placeholder="Date of Birth of Your Dog"></date-picker>
                                            </div>
                                            <div class="text-danger" v-if="!$v.cardData.dogDob.required && $v.cardData.dogDob.$error">Please select date of birth of your dog.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Dog Owner Name: <em>*</em></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" v-model.trim="cardData.dogOwner" class="form-control" placeholder="Owner Name of The Dog">
                                            </div>
                                            <div class="text-danger" v-if="!$v.cardData.dogOwner.required && $v.cardData.dogOwner.$error">Please enter owner name of the dog.</div>
                                            <div class="text-danger" v-if="!$v.cardData.dogOwner.minLength && $v.cardData.dogOwner.required && $v.cardData.dogOwner.$error">Minimum 3 characters required.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Owner Contact Number: <em>*</em></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-mobile"></i></span>
                                                </div>
                                                <input type="text" v-model.trim="cardData.dogOwnerContactNumber" maxlength="12" class="form-control" placeholder="Owner Contact Number">
                                            </div>
                                            <div class="text-danger" v-if="!$v.cardData.dogOwnerContactNumber.required && $v.cardData.dogOwnerContactNumber.$error">Please enter contact number of the owner.</div>
                                            <div class="text-danger" v-if="!$v.cardData.dogOwnerContactNumber.regxNumeric && $v.cardData.dogOwnerContactNumber.required && $v.cardData.dogOwnerContactNumber.$error">Please enter valid contact number.</div>
                                            <div class="text-danger" v-if="!$v.cardData.dogOwnerContactNumber.minLength && $v.cardData.dogOwnerContactNumber.regxNumeric && $v.cardData.dogOwnerContactNumber.required && $v.cardData.dogOwnerContactNumber.$error">Minimum 10 digits required.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Dog Living Address:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-igloo"></i></span>
                                                </div>
                                                <textarea v-model.trim="cardData.dogAddress" maxlength="90" class="form-control" placeholder="Living Address of The Dog"></textarea>
                                            </div>
                                            <div class="text-danger" v-if="!$v.cardData.dogAddress.required && $v.cardData.dogAddress.$error">Please enter living address of the dog.</div>
                                        </div>
                                        <div class="form-group text-right">
                                            <button type="button" class="btn btn-sm btn-light" @click="getBrowserLocation()"><i class="fas fa-map-marker-alt"></i> use GPS for address</button>
                                        </div>
                                        <div class="form-group" v-if="dogVaccinationList.length > 0">
                                            <label class="form-label">Dog Vaccination List:</label>
                                            <p v-for="item in dogVaccinationList" v-bind:key="item.id" class="vac-p">
                                                <input type="checkbox" v-model.trim="cardData.dogVaccinationInfo" :value="item.name" :id="item.name"> <label :for="item.name">{{item.name}}</label>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-info primary-button">Create & Download</button>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="button" class="btn btn-danger" v-on:click="resetAllData()">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
</template>

<script>
import { required, minLength } from 'vuelidate/lib/validators'
import validationErrorComponent from './validationErrorsComponent.vue'
import datePicker from 'vue-bootstrap-datetimepicker'
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css'
const regxNumeric = (value, vm) => {
  if (value == '') return true
  if (value != '') {
    return /^[0-9]+$/.test(value)
  }
}
export default {
    name: 'quick-create-ditigal-card',
    components: {
        datePicker,
        validationErrorComponent
    },
    data() {
        return {
            validationErrors: [],
            cardData: {
                dogName: '',
                dogBreed: '',
                dogGender: '',
                dogDob: '',
                dogOwner: '',
                dogOwnerContactNumber: '',
                dogAddress: '',
                dogVaccinationInfo: []
            },
            dateOptions: {
                format: 'MM/DD/YYYY',
                useCurrent: false,
                showClear: true,
                showClose: true,
                maxDate: 'now'
            }, 
            defaultImage: '/public/assets/images/image.png',
            dogBreedList: [],
            dogVaccinationList: [],

            isDogImgExtValid: true,
            isDogImgSizeValid: true,
            isDogImgHasError: false,
            dogImageFile: '',
            displayDogImage: '',
            isDogImageSelected: true,
        }
    },
    watch: {
        
    },
    computed: {
        
    },
    validations: {
        cardData: {
            dogName: {
                required,
                minLength: minLength(3)
            },
            dogBreed: {
                required
            },
            dogGender: {
                required
            },
            dogDob: {
                required
            },
            dogOwner: {
                required,
                minLength: minLength(3)
            },
            dogOwnerContactNumber: {
                required,
                minLength: minLength(10),
                regxNumeric
            },
            dogAddress: {
                required
            },
        }
    },
    methods: {
        async getDogBreeds() {
            var _this = this;
            _this.$root.isPageLoadingActive = true;
            axios.get('/dog-breeds', {
                params: {
                    status: [1]
                }
            }).then(response => {
                _this.dogBreedList = response.data.content.dogBreeds;
                _this.$root.isPageLoadingActive = false;
            }).catch(function (error) {
                _this.$toast.error({
                    title:'System Error',
                    message:'Something went wrong!'
                });
            });
        },
        async getDogVaccination() {
            var _this = this;
            _this.$root.isPageLoadingActive = true;
            axios.get('/dog-vaccination', {
                params: {
                    status: [1]
                }
            }).then(response => {
                _this.dogVaccinationList = response.data.content.dogVaccination;
                _this.$root.isPageLoadingActive = false;
            }).catch(function (error) {
                _this.$toast.error({
                    title:'System Error',
                    message:'Something went wrong!'
                });
            });
        },
        defaultInputInit() {
            var _this = this;
            _this.cardData.dogName = ''
            _this.cardData.dogBreed = ''
            _this.cardData.dogGender = ''
            _this.cardData.dogDob = ''
            _this.cardData.dogOwner = ''
            _this.cardData.dogOwnerContactNumber = ''
            _this.cardData.dogAddress = ''
            
        },
        defaultDogPhotoInit() {
            var _this = this;
            _this.isDogImgExtValid = true
            _this.isDogImgSizeValid = true
            _this.isDogImgHasError = false
            _this.displayDogImage = _this.defaultImage
            _this.dogImageFile = '';
            _this.isDogImageSelected = true;
            _this.$refs.dogPhoto.value = null;
        },
        handleDogImgUploads(event) {
            var _this = this;
            _this.isDogImgExtValid = true
            _this.isDogImgSizeValid = true
            _this.isDogImgHasError = false
            let imgExtArr = ['jpg', 'png', 'jpeg', 'gif'];
            let files = event.target.files;
            let fileLength = files.length;
            let fileName = files[0].name;
            let fileSize = files[0].size;
            let fileNameArr = fileName.split('.');
            let fileExt = fileNameArr[fileNameArr.length - 1].toLowerCase();

            if(!imgExtArr.includes(fileExt)) {
                _this.isDogImgExtValid = false;
                _this.displayDogImage = '/public/assets/images/wrongimage.png';
                _this.isDogImgHasError = true;
                _this.dogImageFile = '';
                _this.$refs.dogPhoto.value = null;
            }
            
            if(fileSize >= 2000000) {
                _this.isDogImgSizeValid = false;
                _this.displayDogImage = '/public/assets/images/wrongimage.png';
                _this.isDogImgHasError = true;
                _this.dogImageFile = '';
                _this.$refs.dogPhoto.value = null;
            }

            if(_this.isDogImgExtValid && _this.isDogImgSizeValid) {
                _this.isDogImgHasError = false;
                var reader = new FileReader();
                reader.onload = function(e) {
                    _this.displayDogImage = e.target.result;
                }
                reader.readAsDataURL(files[0]);
                _this.dogImageFile = _this.$refs.dogPhoto.files;
                _this.isDogImageSelected = true;
            }
        },
        resetDogImage() {
            var _this = this;
            _this.defaultDogPhotoInit();
        },
        createCardSubmit() {
            var _this = this;
            _this.$v.$touch();
            if (_this.dogImageFile == '') {
                _this.isDogImageSelected = false
            }
            if (_this.$v.$error || _this.dogImageFile == '') {
                _this.$toast.error({
                    title:'Validation Error',
                    message:'Please enter all details & proceed.' 
                });
            }
            if (!_this.$v.$error && _this.dogImageFile != '') {
                _this.createCardProcess();
            }
        },
        async createCardProcess() {
            var _this = this;
            //_this.$root.isPageLoadingActive = true;

            _this.$swal({
                title: 'Please Wait ...',
                html: 'Preparing your digital card',
                willOpen () {
                    _this.$swal.showLoading()
                },
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showCancelButton: false,
                showConfirmButton: false
            })
            let formData = new FormData();
            formData.append('name', _this.cardData.dogName);
            formData.append('dog_breed_id', _this.cardData.dogBreed);
            formData.append('date_of_birth', _this.cardData.dogDob);
            formData.append('gender', _this.cardData.dogGender);
            formData.append('owner_name', _this.cardData.dogOwner);
            formData.append('owner_contact_number', _this.cardData.dogOwnerContactNumber);
            formData.append('living_address', _this.cardData.dogAddress);
            formData.append('vaccination_info', _this.cardData.dogVaccinationInfo);

            if (_this.dogImageFile && _this.dogImageFile.length) {
                formData.append('dog_image', _this.dogImageFile[0]);
            }

            var url = "/dog-digital-cards/create";
            const apiResponse = await axios({
                method: 'post',
                url: url,
                data: formData,
                headers: {'Content-Type': 'multipart/form-data'}
            })
            .then(function (response) {
                if (response.data.status == 200) {
                    _this.validationErrors = [];
                    _this.defaultInputInit();
                    _this.defaultDogPhotoInit();
                    _this.$v.$reset();
                    if (response.data.type == 'success') {
                        _this.$toast.success({
                            title:'Success',
                            message:response.data.msg 
                        });
                        setTimeout(function () { 
                            _this.$router.push({ name: 'quick.digitalCard.show', params: { cardNumber: response.data.content.cardInfo.card_number }})
                        }, 3000);
                    }
                    if (response.data.type == 'error') {
                        _this.$swal.close();
                        _this.$root.isPageLoadingActive = false;
                        _this.$toast.error({
                            title:'Error',
                            message:response.data.msg 
                        });
                    }
                }
            })
            .catch(function (error) {
                _this.$swal.close();
                _this.$root.isPageLoadingActive = false;
                if (error.response.status == 422) {
                    _this.validationErrors = error.response.data.content.validationErrors
                    _this.$smoothScroll({scrollTo: document.getElementById('serverValidationBlock')});
                    _this.$toast.error({
                        title:'Validation Error',
                        message:'Please process with valid data'
                    });
                }
                if (error.response.status == 500) {
                    _this.$toast.error({
                        title:'System Error',
                        message:'Something went wrong!'
                    });
                }
            });
        },
        getBrowserLocation() {
            navigator.geolocation.getCurrentPosition(
                position => {
                    console.log(position.coords.latitude);
                    console.log(position.coords.longitude);
                },
                error => {
                    console.log(error.message);
                },
            )   
        },
        resetAllData() {
            var _this = this;
            _this.defaultInputInit();
            _this.defaultDogPhotoInit();
            _this.$v.$reset();
        }
    },
    mounted() {
        var _this = this;
        _this.displayDogImage = _this.defaultImage;
        _this.$root.isHeaderNavShow = true
        _this.$root.isPageLoadingActive = false;
        _this.$swal.close();
        _this.getDogBreeds();
        _this.getDogVaccination();
    }
}
</script>

<style scoped>
p.vac-p {
    line-height: 0px;
    margin: 0;
    padding: 0;
    padding-top: 10px;
}
</style>
