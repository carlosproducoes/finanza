var isInstallment = $('#is_installment')
var numberInstallments = $('#number_installments')

isInstallment.on('click', function () {
    if ($(this).is(':checked')) {
        numberInstallments.parent('div').removeClass('hidden')
        numberInstallments.prop('required', true)
        numberInstallments.prop('disabled', false)
        return
    }

    numberInstallments.parent('div').addClass('hidden')
    numberInstallments.prop('required', false)
    numberInstallments.prop('disabled', true)
})