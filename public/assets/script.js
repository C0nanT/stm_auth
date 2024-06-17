function checkDB () {
    $.ajax({
        url: 'app.php?action=verificarAutomigrate',
        type: 'GET',
        dataType: 'json',
        data: {
            action: 'verificarAutomigrate'
        },
        success: function (data) {

            var alertClass = data.success ? 'alert-success' : 'alert-danger';
            var alertMessage = data.message;

            var alertElement = $('<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                alertMessage +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                '</div>');

            //  $('#alert-container').append(alertElement);
        },
        error: function () {
            var alertElement = $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                'Erro ao verificar a migração do banco de dados.' +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                '</div>');

            $('#alert-container').append(alertElement);
        }
    });
}