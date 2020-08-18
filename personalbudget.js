function showCurrentMonth(){
	printExpensesDetailed();
	printIncomesDetailed();
}

function listeningForElements(){
	$("#currentMonth").click(showCurrentMonth);
	$("#previousMonth").click(showPreviousMonth);
	$("#currentYear").click(showCurrentYear);
}

function showPreviousMonth(){
	
}

function showCurrentYear(){
	
}

function showCustomPeriod(){

}

function drawChart(){
	
	var data = new google.visualization.DataTable();
	
	data.addColumn('string' , 'Expense');
	data.addColumn('number', 'Amount');
	
	data.addRows(expenses.length);
	
	for(i=0; i<expenses.length; i++)
	{
		data.setCell(i, 0, expenses[i].category);
		data.setCell(i, 1, expenses[i].amount);
	}
	
	var options = {
		title:'Wydatki - graficznie',
		titleTextStyle:{color:'#52361b', fontSize:20, bold:1},
		legend: 'none',
		width:'100%',
		height:330,
		backgroundColor:'lightgray',
		sliceVisibilityThreshold:.015,
		margin:'0px',
		paddings:'0px',
		pieHole:0.4,
		borderradius:'20px'
	};

	var chart = new google.visualization.PieChart(document.getElementById('piechart'));
	chart.draw(data, options);
}

function printExpensesDetailed()
{	
	totalExpenses = 0;
	
	var div =  '<form><table class="table table-sm table-striped table-secondary text-center"><thead><tr><th scope="col" colspan="7">Szczegółowe zestawienie wydatków</th></tr><tr><th scope="col">Lp.</th><th><scope="col">Data</th><th><scope="col">Kwota</th><th><scope="col">Sposób płatności</th><th><scope="col">Kategoria</th><th scope="col">Komentarz</th><th scope="col">Usuń</th></tr></thead><tbody>';
	
	for(i=0; i<expenses.length; i++)
	{
		div += '<tr><th scope="row">'+(i+1)+'</th><td>' + expenses[i].date + '</td><td>' + expenses[i].amount + '</td><td>' + expenses[i].paymentMethod + '</td><td>' + expenses[i].category + '</td><td>' + expenses[i].comment + '</td><td><button class="btn btn-sm btn-delete" type="submit" name="deleteExpense" value=' + expenses[i].id + '><i class="icon-cancel"></i></button></td></tr>' ;
	}
	
	div += "</tbody></table></form>";
	
	$('#expensesDetailed').html(div);
	// $('#expenses table').tablesorter({sortList: [[1,1], [0,0]]});
}