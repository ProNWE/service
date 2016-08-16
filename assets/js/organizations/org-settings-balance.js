$(document).ready(function(){
  $('#curent_payments_application').DataTable({
    paging: false,
    scrollY: '50vh',
    scrollCollapse: true,
    searching: true,
    fixedHeader: true,
    order: [[ 4, "desc" ]],
    oLanguage:{
      sEmptyTable:"На данный момент нет заявок на оплату",
      sInfo:"Показано _TOTAL_ заявка(и) на оплату",
      sInfoEmpty:"Показано 0 заявок на оплату",
      sInfoFiltered:"",
      sLengthMenu:"Показано _MENU_ заявка(и) на оплату",
      sLoadingRecords:"Загружается...",
      sProcessing:"Обрабатывается...",
      sSearch:"Введите для поиска:",
      sZeroRecords:"К сожалению, заявки на оплату не найдены, попробуйте изменить строку поиска"
    },
    columnDefs: [ 
      { 'targets' : 'no-sort', 'orderable': false },
      { 'targets': 'datetime','sType': 'de_datetime' }
    ]
  });
  $('#curent_payments_application_wrapper .row').find('.col-sm-6').removeClass('col-sm-6').addClass('col-xs-6');
  $('#curent_payments_application_wrapper .row .col-xs-6:nth-child(1)').text('Текущие заявки на оплату').css('font-size','18px').css('font-weight','bold').css('padding-top','4px');


  $('#history_of_payments').DataTable({
    paging: false,
    scrollY: '50vh',
    scrollCollapse: true,
    searching: true,
    fixedHeader: true,
    scrollX: '100%',
    order: [[ 4, "desc" ]],
    oLanguage:{
      sEmptyTable:"На данный момент Вы ничего не оплачивали",
      sInfo:"Показано _TOTAL_ платеж(а,ей)",
      sInfoEmpty:"Показано 0 платежей",
      sInfoFiltered:"",
      sLengthMenu:"Показано _MENU_ платеж(а,ей)",
      sLoadingRecords:"Загружается...",
      sProcessing:"Обрабатывается...",
      sSearch:"Введите для поиска:",
      sZeroRecords:"К сожалению, платежи не найдены, попробуйте изменить строку поиска"
    },
    columnDefs: [ 
      { 'targets' : 'no-sort', 'orderable': false },
      { 'targets': 'datetime','sType': 'de_datetime' }
    ]
  });
  $('#history_of_payments_wrapper .row').find('.col-sm-6').removeClass('col-sm-6').addClass('col-xs-6');
  $('#history_of_payments_wrapper .row .col-xs-6:nth-child(1)').text('История платежей').css('font-size','18px').css('font-weight','bold').css('padding-top','4px');
});  
