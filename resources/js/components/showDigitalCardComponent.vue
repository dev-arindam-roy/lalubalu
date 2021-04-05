<template>
    <div id="showDigitalCard" class="mt-3 mb-5">
        <div class="card" ref="digitalCardHtml">
            <div class="card-body">
                <div class="card-box">
                    <div class="card-box-header">
                        <div class="image-box" v-bind:style="{ backgroundImage: 'url(' + dogImage + ')' }"></div>
                        <div class="info-box">
                            <label class="dog-name">{{dogName}}</label>
                            <p class="dog-breed">{{dogBreed}} ({{dogGender}})</p>
                            <hr/>
                            <p class="dog-owner">{{dogOwner}}</p>
                            <p class="dog-owner-contact">{{dogOwnerContactNo}}</p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="card-number-box mt-2">{{DogCardNumber}}</div>
                    <div class="qr-box">
                        <img :src="DogQR" class="img-fluid img-thumbnail rounded qr-image">
                    </div>
                    <div class="address-box"><p>{{DogAddress}}</p></div>
                    <div class="barCode-box">
                        <img :src="DogBarCode" class="barcode-image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'show-ditigal-card',
    components: {
        
    },
    data() {
        return {
            dogImage: '/public/assets/images/dog.png',
            cardNumber: '',
            dogName: '',
            dogBreed: '',
            dogGender: '',
            dogOwner: '',
            dogOwnerContactNo: '',
            DogCardNumber: '',
            DogQR: '',
            DogAddress: '',
            DogBarCode: '',
            imageData: null,
        }
    },
    watch: {
        
    },
    computed: {
        
    },
    validations: {
        
    },
    methods: {
        async getCardDetails() {
            var _this = this;
            axios.get(`/dog-digital-cards/${_this.cardNumber}`).then(response => {
                var _this = this;
                if (response.data.status == 200) {
                    if (response.data.content.cardDetails.dog_image && response.data.content.cardDetails.dog_image != '' && response.data.content.cardDetails.dog_image != null) {
                        _this.dogImage = '/public/uploads/thumbs/' + response.data.content.cardDetails.dog_image;
                    }
                    _this.dogName = response.data.content.cardDetails.name;
                    _this.dogBreed = response.data.content.breedInfo.name;
                    _this.dogGender = response.data.content.cardDetails.gender;
                    _this.dogOwner = response.data.content.cardDetails.owner_name;
                    _this.dogOwnerContactNo = response.data.content.cardDetails.owner_contact_number;
                    _this.DogCardNumber = response.data.content.cardDetails.card_number;
                    _this.DogQR = '/public/uploads/qrcodes/' + response.data.content.cardDetails.card_number + '.svg';
                    _this.DogBarCode = '/public/uploads/barcodes/' + response.data.content.cardDetails.card_number + '.svg';
                    _this.DogAddress = response.data.content.cardDetails.living_address;

                    if (response.data.content.cardDetails.card_image && response.data.content.cardDetails.card_image != '' && response.data.content.cardDetails.card_image != null) {
                        setTimeout(function () { 
                            _this.$router.push({ name: 'quick.digitalCard.download', params: { cardNumber: response.data.content.cardDetails.card_number }})
                        }, 2000);
                    } else {
                        setTimeout(function () { 
                            _this.saveImageProcess();
                        }, 2000);
                    }
                }
            }).catch(function (error) {
                window.location.href = '/';
            });
        },
        async saveImageProcess() {
            var _this = this;
            _this.$swal({
                title: 'Please Wait ...',
                html: 'Processing your card for download <br/> <i class="fas fa-hourglass-half"></i> <br/> Almost done, just few Seconds',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showCancelButton: false,
                showConfirmButton: false
            })
            const el = this.$refs.digitalCardHtml;
            const options = {
                type: 'dataURL',
                allowTaint: false,
                logging: true,
                letterRendering: true,
                backgroundColor: null,
                scale: 2
            }
            _this.imageData = await this.$html2canvas(el, options);
            if (_this.imageData && _this.imageData != '' && _this.imageData != null) {
                var url = `/dog-digital-cards/save-card-image/${_this.cardNumber}`;
                const apiResponse = await axios({
                    method: 'post',
                    url: url,
                    data: {
                        card_image: _this.imageData
                    },
                    headers: {'Content-Type': 'application/json'}
                })
                .then(function (response) {
                    if (response.data.status == 200) {
                        if (response.data.type == 'success') {
                            _this.$toast.success({
                                title:'Success',
                                message:response.data.msg 
                            });
                            setTimeout(function () { 
                                _this.$router.push({ name: 'quick.digitalCard.download', params: { cardNumber: response.data.content.card.card_number }})
                            }, 3000);
                        }
                        if (response.data.type == 'error') {
                            window.location.href = '/';
                        }
                    }
                })
                .catch(function (error) {
                    window.location.href = '/';
                });
            }
        }
    },
    mounted() {
        var _this = this;
        _this.$root.isPageLoadingActive = true;
        _this.$root.isHeaderNavShow = false
        _this.cardNumber = _this.$route.params.cardNumber
        _this.getCardDetails();
    }
}
</script>

<style scoped>
.card {
    width: 575px !important;
    margin: 60px auto;
}
.image-box {
    width: 100px;
    height: 100px;
    float: left;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    box-shadow: inset 0 0 10px rgb(68, 68, 68);
    border: 3px solid #ddd;
    border-radius: 8px;
}
.info-box {
    width: 70%;
    float: left;
    text-align: left;
    padding-left: 10px;
    color: #fff;
}
.card-body {
    box-shadow: inset 0 3px 6px rgba(0,0,0,0.16), 0 4px 6px rgba(0,0,0,0.45);
    background: linear-gradient(90deg, #1CB5E0 0%, #000851 100%);
}
.dog-name {
    font-size:20px;
    font-weight: bold;
}
.dog-breed {
    line-height: 0px;
}
.dog-owner {
   line-height: 0px;
   font-weight: 700;
   font-size: 12px;
}
.dog-owner-contact {
    line-height: 5px;
    font-weight: 700;
    font-size: 12px;
}
hr {
    margin-top:4px !important;
    margin-bottom: 10px !important;
}
.card-number-box {
    background: linear-gradient(90deg, #e3ffe7 0%, #d9e7ff 100%);
    padding: 15px;
    letter-spacing: 10px;
    font-size: 18px;
    font-weight: bold;
    border-radius: 12px;
    color:#044486;
}
.qr-box {
    position: absolute;
    top: 90px;
    right: 66px;
}
.qr-image {
    width: 120px;
    border: 2px solid #115586;
}
.address-box {
    width: 100%;
}
.address-box p {
    width: 65%;
    max-height: 40px;
    overflow: hidden;
    font-size: 12px;
    margin-top: 6px;
    margin-left: 6px;
    color: #fff;
}
.barcode-image {
    max-width: 100%;
    height: auto;
}
.download-action {
    margin-top: 25px;
    text-align: center;
}
/*@media (min-width: 360px) and (max-width: 575px)*/
</style>
