<template>
<div>
<div class="container">
        <Menu />
     <br>
    <button class="btn btn-success" data-toggle="modal" data-target="#addNew" @click="openModalWindow">Crear Porducto <i></i></button>

   <table class="table table-hover  table-bordered">
    <thead>
      <tr>
        <th>Id</th>
        <th>Nombre del producto</th>
        <th>Talla</th>
        <th>Observaciones</th>
        <th>Marca del producto</th>
        <th>Cantidad en inventario</th>
        <th>Fecha de embarque</th>
        <th>Accion</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="product in products" :key="product.id">
        <td>{{product.id}}</td>
        <td>{{product.name}}</td>
        <td v-if="product.size == 1">S</td>
        <td v-if="product.size ==2">M</td>
        <td v-if="product.size ==3">L</td>

        <td>{{product.observation}}</td>
        <td>{{product.brand.name}}</td>
        <td>{{product.quantity_stock}}</td>
        <td>{{product.boarding_date}}</td>
        <td><a href="#" data-id="user.id" class="btn btn-info" @click="editModalWindow(product)"> Editar</a>
            <a href="#" class="btn btn-danger" @click="DeleteProduct(product.id)">Eliminar</a>
        </td>

      </tr>
    </tbody>
  </table>
  <div class="modal fade bd-example-modal-lg" tabindex="-1" id="addNew" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                <div class="modal-header">

                    <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Crear producto </h5>
                    <h5 v-show="editMode" class="modal-title" id="addNewLabel">Actualizar producto</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form @submit.prevent="editMode ? updateProduct() : createProduct()">
                    <div class="modal-body">
                      <div class="form-row">

                     <div class="form-group col-md-6">
                       <label for="document_number"> Nombre del producto </label>
                        <input v-model="forms.name" type="text"  placeholder="Nombre del producto" class="form-control" >
                      </div>

                    <div class="form-group col-md-3">
                      <label for="form-control">Talla</label>
                       <select  v-model="forms.size" class="form-control" >
                           <option v-for="option in options" v-bind:value="option.value">
                             {{ option.text }}
                            </option>
                        </select>
                   </div>

                    <div class="form-group col-md-3">
                      <label for="form-control">Marca</label>
                      <select  v-model="forms.brand_id" class="form-control" >
                            <option value="" selected>Seleccione</option>

                           <option v-for="brand in brands" v-bind:value="brand.id">
                             {{ brand.name }}
                            </option>
                        </select>
                   </div>

                     <div class="form-group col-md-6">

                      <label for="form-control">Cantidad en inventario</label>
                      <input v-model="forms.quantity_stock" type="number"  placeholder="Cantidad en inventario" class="form-control"  >
                   </div>

                     <div class="form-group col-md-6">

                      <label for="form-control">Fecha de embarque</label>
                      <input v-model="forms.boarding_date" type="date"  placeholder="Referencia" class="form-control"  >
                   </div>

                     <div class="form-group col-md-12">
                      <label for="form-control">Observaciones</label>
                     <textarea v-model="forms.observation"  class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>

                   </div>
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
                products:{},
                brands: {},
               
                forms: {
                    id: '',
                    name:'',
                    observation:'',
                    quantity_stock:'',
                    boarding_date:'',
                    size:'',
                    brand_id:''
                },
                formedit:{},
                 options: [
                    { text: 'Seleccione', value:''  },
                    { text: 'S', value: 1 },
                    { text: 'M', value: 2 },
                    { text: 'L', value: 3 },
                 ]
            }
        },
    mounted() {
      this.getBrands();
      this.getProducts();
    },
    methods: {
    getBrands(){ 
          axios.get('api/brand/get').then((response) => {
            this.brands =response.data
         }).catch((errors) => {
           
         })
    },
    getProducts(){
         axios.get('api/product/get').then((response) => {
            this.products =response.data
         }).catch((errors) => {
           
         })
    },

    createProduct(){
        if (this.forms.name == '') {
            Swal.fire({
                icon: 'error',title: 'el campo nombre del producto nombre es obligatorio'
              })
        }else if (this.forms.size =='') {
          Swal.fire({
                icon: 'error',title: 'el campo talla  es obligatorio'
        });
        }else if (this.forms.observation =='') {
          Swal.fire({
                icon: 'error',title: 'el campo observaciones es obligatorio'
        });
        }else if (this.forms.quantity_stock =='') {
          Swal.fire({
                icon: 'error',title: 'el campo cantidad en inventario es obligatorio'
        });
         }else if (this.forms.boarding_date =='') {
          Swal.fire({
                icon: 'error',title: 'el campo fecha de embarque es obligatorio'
        });
         }else if (this.forms.brand_id =='') {
          Swal.fire({
                icon: 'error',title: 'el campo marca es obligatorio'
        });
        
      }else{
         axios.post('api/product/create',this.forms).then((response) => {
            this.products =response.data
             $('#addNew').modal('hide');
             Swal.fire({
               icon: 'success',title: 'El producto se ha registrado con exito'
              })
             this.getProducts();

         }).catch((errors) => {
           this.errors = errors.response.data.errors
           Swal.fire({
                icon: 'error',title: 'ha ocurrido un fallo en el servidor'
              })
         })
      }
    },
    updateProduct(){
      const data  = this.forms
       if (data.name =='') {
            Swal.fire({
                icon: 'error',title: 'el campo nombre del producto nombre es obligatorio'
              })
        }else if (data.size =='') {
          Swal.fire({
                icon: 'error',title: 'el campo talla  es obligatorio'
        });
        }else if (data.observation =='') {
          Swal.fire({
                icon: 'error',title: 'el campo observaciones es obligatorio'
        });
        }else if (data.quantity_stock =='') {
          Swal.fire({
                icon: 'error',title: 'el campo cantidad en inventario es obligatorio'
        });
         }else if (data.boarding_date =='') {
          Swal.fire({
                icon: 'error',title: 'el campo fecha de embarque es obligatorio'
        });
         }else if (data.brand_id =='') {
          Swal.fire({
                icon: 'error',title: 'el campo marca es obligatorio'
        });
        
      }else{
          axios.post('api/product/update',data).then((response) => {
            const index = this.products.findIndex(item => item.id === data.id);
             this.products[index] = data
            $('#addNew').modal('hide');
             Swal.fire({
                icon: 'success',title: 'el producto  se ha actualizado con exito'
              })
             this.getProducts();

         }).catch((errors) => {
          this.errors = errors.response.data.errors
               Swal.fire({
                icon: 'error',title: 'ha ocurrido un fallo en el servidor'
              })
         })
      }
     
    },
    DeleteProduct(data){
      Swal.fire({
        title: 'Esta seguro de eliminar el producto',
       showCancelButton: true,
         icon: 'warning',
       confirmButtonText: `Eliminar`,
       }).then((result) => {
         if (result.value) {
             const dato= {
                 'id':data
             }
          axios.post('api/product/delete',dato).then((response) => {
            Swal.fire({
                icon: 'success',title: 'el producto se ha eliminado con exito'
              })
            this.getProducts();

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
          this.forms= {
                    id: '',
                    name:'',
                    reference:'',
                    observation:'',
                    quantity_stock:'',
                    boarding_date:'',
                    size:'',
                    brand_id:''
                },
        $('#addNew').modal('show');
     },
     editModalWindow(data){
          const dato ={
              'id':data.id,
              'name' :data.name,
              'observation':data.observation,
              'quantity_stock' :data.quantity_stock,
              'boarding_date': data.boarding_date,
              'size':data.size,
              'brand_id':data.brand_id
          }
        this.errors ={}
        this.forms={}
        this.editMode = true;
         this.forms =dato
        $('#addNew').modal('show');
        }
    }
}
</script>

<style>
</style>