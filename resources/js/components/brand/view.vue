<template>
<div>
<div class="container">
        <Menu />

     <br>
    <button class="btn btn-success" data-toggle="modal" data-target="#addNew" @click="openModalWindow">Crear Marca <i></i></button>

   <table class="table table-hover  table-bordered">
    <thead>
      <tr>
        <th>Id</th>
        <th>Nombre Completo</th>
        <th>Referencia</th>
        
        <th>Accion</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="brand in brands" :key="brand.id">
        <td>{{brand.id}}</td>
        <td>{{brand.name}}</td>
        <td>{{brand.reference}}</td>
        <td><a href="#" data-id="user.id" class="btn btn-info" @click="editModalWindow(brand)"> Editar</a>
            <a href="#" class="btn btn-danger" @click="DeleteBrand(brand.id)">Eliminar</a>
        </td>

      </tr>
    </tbody>
  </table>
     <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">

                    <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Crear Marca </h5>
                    <h5 v-show="editMode" class="modal-title" id="addNewLabel">Actualizar Marca</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form @submit.prevent="editMode ? updateBrand() : createBrand()">
                     <div class="modal-body">
                      <div class="form-group">
                       <label for="document_number">nombre </label>
                        <input v-model="form.name" type="text"  placeholder="Nombre" class="form-control" >
                      </div>

                    <div class="form-group">
                      <label for="second_name">Referencia</label>
                      <input v-model="form.reference" type="text"  placeholder="Referencia alfanumerico" class="form-control"  >
                   </div>
              </div>
             <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               <button v-show="editMode" type="submit" class="btn btn-primary">Actualizar</button>
               <button v-show="!editMode" type="submit" class="btn btn-primary">Crear</button>
           </div>
        </form>
       </div>
    </div>
</div>
</div> 
</div>

</template>

<script>
import Menu from '../menu.vue'
export default {  
      components: {
          Menu
      },
      
    data() {
            return {
                editMode: false,
                brands: {},
                form: {
                    id: '',
                    name:'',
                    reference:''
                },
                formedit:{},
                errors: {},
            }
        },
    mounted() {
      this.getBrands();
    
    },
    methods: {
    getBrands(){ 
          axios.get('api/brand/get').then((response) => {
            this.brands =response.data
         }).catch((errors) => {
           
         })
    },
    createBrand(){
        if (this.form.name == '') {
            Swal.fire({
                icon: 'error',title: 'el campo numero nombre es obligatorio'
              })
      }else if (this.form.reference =='') {
            Swal.fire({
                icon: 'error',title: 'el campo refrencia es obligatorio'
              });
      }else{
         axios.post('api/brand/create',this.form).then((response) => {
            this.brands =response.data
             $('#addNew').modal('hide');
             Swal.fire({
               icon: 'success',title: 'La marca se ha registrado con exito'
              })
             this.getBrands();

         }).catch((errors) => {
           this.errors = errors.response.data.errors
           Swal.fire({
                icon: 'error',title: 'ha ocurrido un fallo en el servidor'
              })
         })
      }
    },
    updateBrand(){
      const data  = this.form
      if (data.name == '' ) {
            Swal.fire({
                icon: 'error',title: 'el campo nombre  es obligatorio'
           })

      }else if (data.reference =='') {
          Swal.fire({
                icon: 'error',title: 'el campo referencia es obligatorio'
              });
      }else{
          axios.post('api/brand/update',data).then((response) => {
            const index = this.brands.findIndex(item => item.id === data.id);
             this.brands[index] = data
            $('#addNew').modal('hide');
             Swal.fire({
                icon: 'success',title: 'la marca  se ha actualizado con exito'
              })
             this.getBrands();

         }).catch((errors) => {
          this.errors = errors.response.data.errors
               Swal.fire({
                icon: 'error',title: 'ha ocurrido un fallo en el servidor'
              })
         })
      }
     
    },
    DeleteBrand(data){
      Swal.fire({
        title: 'Esta seguro de eliminar la marca',
       showCancelButton: true,
         icon: 'warning',
       confirmButtonText: `Eliminar`,
       }).then((result) => {
         if (result.value) {
             const dato= {
                 'id':data
             }
          axios.post('api/brand/delete',dato).then((response) => {
            Swal.fire({
                icon: 'success',title: 'la marca se ja eliminado con exito'
              })
            this.getBrands();

         }).catch((errors) => {
               Swal.fire({
                icon: 'error',title: 'ha ocurrido un fallo en el servidor'
              })
         })
     }
    })
        
      
    },
    openModalWindow(){
         this.errors ={}
         this.editMode = false
          this.form= {
                    id: '',
                    name : '',
                    reference: ''
                },
        $('#addNew').modal('show');
     },
     editModalWindow(data){
          const dato ={
              'id':data.id,
              'name' :data.name,
              'reference':data.reference
          }
        this.errors ={}
        this.form={}
        this.editMode = true;
         this.form =dato
        $('#addNew').modal('show');
        }
    }
}
</script>

<style>
</style>