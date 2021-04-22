<template>
    <div id="downloadDigitalCard" class="mt-3 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="digital-card-image">
                        <img :src="cardImage" class="img-fluid img-thumbnail rounded card-image">
                    </div>
                    <div class="download-action mt-3">
                        <div class="row">
                            <div class="col-md-8">
                                <a :href="cardImage" class="btn btn100 btn-info primary-button" :download="cardName"><i class="fas fa-download"></i> Download As Image</a>
                                <button type="button" class="btn btn100 btn-info primary-button" v-on:click="saveAsPDF()"><i class="fas fa-file-pdf"></i> Download As PDF</button>
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="button" class="btn btn100 btn-danger" v-on:click="createNew()">Create New</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </div>
    </div>
</template>

<script>
import jsPDF from 'jspdf'
export default {
    name: 'download-ditigal-card',
    components: {
        
    },
    data() {
        return {
            cardImage: null,
            cardName: '',
            pdfName: 'lalubalu.pdf'
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
            _this.$root.isPageLoadingActive = true;
            axios.get(`/dog-digital-cards/${_this.cardNumber}`).then(response => {
                var _this = this;
                _this.$root.isPageLoadingActive = false;
                if (response.data.status == 200) {
                    _this.cardImage = response.data.content.cardDetails.card_image;
                    _this.cardName = response.data.content.cardDetails.card_number + '.png';
                    _this.pdfName = response.data.content.cardDetails.card_number + '.pdf';
                }
            }).catch(function (error) {
                var _this = this;
                if (error.response.status == 404) {
                    window.location.href = '/404';
                }
                if (error.response.status == 500) {
                    _this.$toast.error({
                        title:'System Error',
                        message:'Something went wrong!'
                    });
                }
            });
        },
        saveAsPDF() {
            var _this = this;
            var doc = new jsPDF("p", "pt", "a4")
            doc.addImage(_this.cardImage, 'PNG', 50, 50, 500, 250);
            doc.save(_this.pdfName);
        },
        createNew() {
            this.$router.push({name: 'quick.digitalCard'});
        }
    },
    mounted() {
        var _this = this;
        _this.$root.isHeaderNavShow = true
        _this.cardNumber = _this.$route.params.cardNumber
        _this.$root.isPageLoadingActive = false;
        _this.getCardDetails();
        _this.$swal.close();
    }
}
</script>

<style scoped>
@media screen and (max-width: 992px) {
  .btn100 {
    width: 100%;
    margin-bottom: 10px;
  }
}
</style>
