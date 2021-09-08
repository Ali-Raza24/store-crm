<template>
    <div id="modalDelete" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal fade refund-modal" id="sureRefund" tabindex="-1" style="display: none;" aria-hidden="true">-->
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h2 class="font-weight-700 dark-one mb-2">Delete</h2>
                                    <h4 class="dark-two mb-3">Are you sure to delete this?</h4>
                                    <a href="javascript:void(0)" @click="deleteBrandConfirmation()" class="btn-size btn-rounded btn-primary ml-1 mr-1"> Ok </a>
                                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal"> Cancel </a>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
</template>
<script>
export default {
name: "ConfirmDelete",
    props: {
        delete_url: {
            type: String,
            default: ''
        }
    },
    data: function () {
        return {
            deleteConfirmID: '',
            deleteConID: ''

        }
    },
    methods: {
        show: function() {
            $('#modalDelete').modal('show')
        },
        deleteBrandId:function(deleteID){
            this.deleteConID=deleteID

        },
        deleteCategoryId:function(deleteID){

            this.deleteConID=deleteID
        },
        deleteBrandConfirmation:function(){

            axios.delete(this.delete_url+"/"+this.deleteConID,
            ).then(response => {
                window.location.reload()
            });
        }

    }
}
</script>

<style scoped>

</style>
