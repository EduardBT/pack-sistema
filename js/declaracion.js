// Variables globales

const formularioUI = document.querySelector('#formulario');
const listaPedidosUI = document.getElementById('listaProductos');
const confir = document.getElementById('confirmacion');
let arrayProductos = [];


// para agregar el producto al pedido
const CrearItem = (producto,cantidad,monto) => {
  let item = {
    producto: producto,
    cantidad:cantidad,
    unitario:monto,
    monto:monto*cantidad,
    
    
  }
  arrayProductos.push(item);
  return item;
}

//Guarda en LocalStorage 
const GuardarDB = () => {
  localStorage.setItem('pedido', JSON.stringify(arrayProductos));
  PintarDB();
}

//llena el carrito con los productos pedidos y la cantidad
const PintarDB = () => {
  listaPedidosUI.innerHTML = '';
  let total=0;
  let pedido="";
  arrayProductos = JSON.parse(localStorage.getItem('pedido'));

  if(arrayProductos === null){
    arrayProductos = [];
  }else{
 

    arrayProductos.forEach(element => {

      listaPedidosUI.innerHTML += `<div class="carrito detalle" ><b>${element.producto}</b> - Cantidad Quiality: ${element.cantidad}- Precio Unitario/${element.unitario}- Cantidad Amount/${element.monto}<span><i class="material-icons">delete</i></span></div>`
      pedido=pedido+" - "+element.producto +" Cant:"+ element.cantidad+" unitario"+element.unitario+" monto"+element.monto;
      total=total+element.monto;
    });
    listaPedidosUI.innerHTML += `<div class="carrito detalle">----------- Total declarado:  S/${total}<span></span></div>`
    confir.innerHTML=`<div class="carrito detalle">-Imprimir declaración WhatsApp: <a id="whatsapp" href="https://api.whatsapp.com/send?phone=584148463183&text=${pedido}" target="_blank"><i class="fas fa-phone telefono icon" aria-hidden="true"></i></a></div>`

  }

}


const EliminarDB = (producto) => {
  let indexArray;
  arrayProductos.forEach((elemento, index) => {

    if(elemento.producto === producto){
      indexArray = index;
    }
    
  });

  arrayProductos.splice(indexArray,1);
  GuardarDB();

}


// EventListener llena los objetos con el producto, cantidad y el precio

formularioUI.addEventListener('submit', (e) => {

  e.preventDefault();
  let productoUI = document.querySelector('#producto').value;
  let cantidadUI=document.querySelector('#cantidad').value
  let montoUI=document.querySelector('#precio').value
  CrearItem(productoUI,cantidadUI,montoUI);
  GuardarDB();
  formularioUI.reset();

});

document.addEventListener('DOMContentLoaded', PintarDB);
listaPedidosUI.addEventListener('click', (e) => {   //si se hace click sobre un elemento de la lista
  e.preventDefault();
  if(e.target.innerHTML === 'delete'){
    let texto = e.path[2].childNodes[1].innerHTML;
      EliminarDB(texto);  // para eliminar un producto del pedido
  }

});
