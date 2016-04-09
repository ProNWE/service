$(document).ready (function() {
	$('#table-my-event').dataTable({
		'paging': false,
		'ordering':  false,
		'searching': true,
		'info': true,
		'scrollX': true,
		oLanguage:{
			oPaginate:{
				sNext:"<em class='fa fa-angle-right' style='font-size:1.2em'></em>",
				sPrevious:"<em class='fa fa-angle-left' style='font-size:1.2em'></em>"
			},
			sEmptyTable:"Вы не создали ещё мероприятия. Нажмите в левом меня на 'Создать мероприятие'",
			sInfo:"Показано _START_-_END_  из _TOTAL_ мероприятий",
			sInfoEmpty:"Показано 0 мероприятий",
			sInfoFiltered:"(отсортировано из _MAX_ мероприятий)",
			sLengthMenu:"Показано _MENU_ мероприятий",
			sLoadingRecords:"Загружается...",
			sProcessing:"Обрабатывается...",
			sSearch:"Введите для поиска:",
			sZeroRecords:"Мероприятия не найдены"
		},
		columnDefs: [ 
			{ 'targets' : 'no-sort', 'orderable': false },
			{ 'targets': 'datetime','sType': 'de_datetime' }
		]
	});

	var url = location.protocol+'//'+location.hostname+'/pronwe/';

	$("a[id~='deleteEvent'").click( function() {
		var data = $(this).closest('tr').attr('id');

		list = data.split('_');
		id = list[1];

		$.ajax({
			url: url+'deleteEvent/',
			data: {
				'id' : id
			},
			success: function(data, config) {
				console.log(data);
				//window.location.reload();
			},
			error: function(data, config) {
				console.log(data);
			}
		});
	});
});