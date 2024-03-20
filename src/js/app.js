document.addEventListener('DOMContentLoaded', function(){   //callback
    eventListeners();
    darkMode();
    // darkChange();

    //codigo que retira el anuncio de propiedad eliminada o actualizada
    // borraMensaje();
});
    



function darkMode(){
    //Guardar el estado del darkMode en el localStorage

    //Comprueba si estaba habilitado darkMode
    let darkLocal = window.localStorage.getItem('dark');
    if (darkLocal === 'true'){
        document.body.classList.add('darkMode');
    }

    //Codigo que permite el darkMode usando el boton de luna
    // const botonDarkMode = document.querySelector('.dark-mode-boton');
    // botonDarkMode.addEventListener('click', function(){
    //     document.body.classList.toggle('darkMode');
    // });
    document.querySelector('.dark-mode-boton').addEventListener('click', darkChange);
}

function darkChange(){
    let darkLocal = window.localStorage.getItem('dark');

    if(darkLocal===null || darkLocal ==='false'){
        //no se habia inicializado darkLocal
        window.localStorage.setItem('dark', true);
        document.body.classList.add('darkMode');
    }else{
        //Si ya era true, se pasa a false
        window.localStorage.setItem('dark', false);
        document.body.classList.remove('darkMode')
    }
}

function eventListeners(){
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);

    //muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]'); //selecciona los elementos telefono y email
    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto)); //hace un barrido para agregar eventos
}
function navegacionResponsive(){
    const navegacion = document.querySelector('.navegacion')

    navegacion.classList.toggle('mostrar'); //elimina o agrega la clase mostrar
}

function mostrarMetodosContacto(event){
    const contactoDiv = document.querySelector('#contacto'); //selecciona id contacto

    if(event.target.value === 'telefono'){
        //se usa template string para crear codigo html
        contactoDiv.innerHTML = ` 
            <label for="telefono">Número de Teléfono</label>
            <input type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]">
            
            <p>Elija la fecha y  hora para ser contactado</p>

            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
        `;
    } else{
        contactoDiv.innerHTML = `
            <label for="email">E-mail</label>
            <input type="email" placeholder="Tu E-mail" id="email" name="contacto[email]" >
        `;
    }
    console.log(event);
}

// function borraMensaje() {
//     const mensajeConfirm = document.querySelector('.alerta');
//     if(mensajeConfirm !== null){ //si .alerta existe
//         setTimeout(function() { //elimina la clase padre en 3.5s
//             const padre = mensajeConfirm.parentElement;
//             padre.removeChild(mensajeConfirm);
//         }, 3500);
//         // console.log("No hay mensaje de error");
//     }else { //No existe
//         console.log("Hay mensaje de error");
//     }
// }