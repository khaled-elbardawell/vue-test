<template>
    <div class="container">
        <div class="row">
            <form>
                <div class="mb-3">
                    <label class="form-label">en</label>
                    <input v-model="dataRow.en" type="text" class="form-control" >
                </div>

                <div class="mb-3">
                    <label class="form-label">ar</label>
                    <input v-model="dataRow.ar" type="text" class="form-control" >
                </div>

                <button @click.prevent ="add()" class="btn btn-primary">Add</button>
            </form>
        </div>

        <div class="row mt-5 justify-content-center">

            <table class="table">
                <thead>
                <tr c>
                    <th scope="col">ar</th>
                    <th scope="col">en</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="data in dataTable">
                    <td>{{data.ar}}</td>
                    <td>{{data.en}}</td>
                    <td>

                        <!-- Button trigger modal -->
                        <button @click="edit(data)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Edit
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="mt-5 mb-5">
                                            <div class="form-row">

                                                <div class="col">
                                                    <label>en</label>
                                                    <input v-model="dataToEdit.en" type="text" class="form-control">
                                                </div>

                                                <div class="col">
                                                    <label>ar</label>
                                                    <input v-model="dataToEdit.ar" type="text" class="form-control">
                                                </div>
                                            </div>




                                        </form>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button  @click.prevent="update()" type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>

        <button @click.prevent ="save()" class="btn btn-primary">Save</button>

    </div>
</template>

<script>
    export default {
        data : function () {
             return {
                 dataRow : {id:0,ar:"",en:""},
                 dataToEdit : {id:0,ar:"",en:""},
                 dataTosave :[],
                 dataTable : [],
                 lastId: 0,


             }
        },
        created() {
            this.getList();
        },
        methods:{
            add : function(id){
                    if ( this.dataRow.en != "" ||  this.dataRow.ar != ""){
                        this.dataRow.id = ++this.lastId;
                        this.dataTable.push(this.dataRow);
                        this.dataTosave.push(this.dataRow);

                        this.dataRow = {id:this.lastId,ar:"",en:""};
                    }
                },
            edit : function(data){
                    this.dataToEdit.ar = data.ar ;
                    this.dataToEdit.en =data.en ;
                    this.dataToEdit.id = data.id;
            },
            save:function () {

                const self = this;

                axios.post('/api/save', {
                        lists: self.dataTosave
                }
                )

                    .then(function (response) {
                        // self.dataTable.push(response['data']);
                        //
                        // self.dataRow = {id:0,ar:"",en:""};


                    })
                    .catch(function (error) {
                        console.log(error);
                    });




            },
            getList: function () {
                const self = this;
                axios.get('api/getList')
                    .then(function (response) {
                        self.dataTable = response.data.data;
                        self.lastId = parseInt( response.data.id );
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
            },
            update :function () {
                const self = this;

                if ( this.dataToEdit.en != "" ||  this.dataToEdit.ar != ""){
                    self.dataTable.forEach(function (i) {
                        if (i.id == self.dataToEdit.id ){
                            i.id =  self.dataToEdit.id
                            i.en =  self.dataToEdit.en
                            i.ar =  self.dataToEdit.ar

                            let state = false;
                             self.dataTosave.forEach(function(i){
                                if (i.id == self.dataToEdit.id ){
                                    state = true;
                                }
                            })

                            if (!state){
                                self.dataTosave.push(self.dataToEdit);
                            }
                        }
                    });


                }

            }
        }
    }
</script>
