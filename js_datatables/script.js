$(document).ready(function () { //renderiza a table em formato de idioma portugues
    
    $('table').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json'
        }
    });
    
});