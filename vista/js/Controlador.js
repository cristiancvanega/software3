/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//console.log("carga");
//$(document).ready(function (){
//    
//});
var idProducto, cantidad;
$(document).ready(function() {
    carga();
    $('#pedido label').click(function() {
        alert("hola");
    });
    $('#btnEnviar').click(function() {
        var cantidad = $('#txtCantidad').val();
        if (cantidad) {
            $.post('controlador/DAO.php', {
                id: cantidad,
                clase: "CargarVista",
                oper: "rutaFoto"
            }, function(exito) {
//                alert(exito);
                var img = "<img src=" + exito + " id=imgProducto>";
                $('#imagen').html(img);
            });
        } else {
            $('#divError').fadeIn(500).addClass('error').html('Llena todo').fadeOut(1000);
        }
    });

    $('#0').click(function() {
        alert("Hola");
    });
});

function carga() {
//    alert("alert");
    $.post('controlador/DAO.php ', {
        clase: "cargarVista",
        oper: "cargaProductos"
    }, function(exito) {
        console.log(exito);
        $("#productos").html(exito);
    });
}

$(document).on("click", "#productos label", function(event) {
    var idPr = event.target.id;
    idProducto = idPr;
    $.post('controlador/DAO.php', {
        id: idPr,
        clase: "CargarVista",
        oper: "rutaFoto"
    }, function(exito) {
        console.log(exito);
        var content = exito ;
        $('#imagen').html(content);
    });
    
    $.post( 'Controlador/DAO.php' , {
            id : idPr,
            clase : "CargarVista",
            oper : "getCantidad"
    }, function (response){
        cantidad = response;
        $( '#lblCantidad' ).text("Cantidad máx: "+response);
//        alert(response);
    });
});

