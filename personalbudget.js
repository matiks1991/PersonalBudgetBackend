var userName = "Artur";

window.onload = writeUserName;

function writeUserName()
{
	$('.user').html(userName);
}

function setCurrentDate()
{
	var today = new Date();

	var date = today.toISOString().substr(0, 10);
	
	$('#date').val(date);
}

function setCurrentDate()
{
	var today = new Date();

	var date = today.toISOString().substr(0, 10);
	
	$('#date').val(date);
}

function showCurrentMonth(){
	printExpenses();
	printIncomes();
	printBalance();
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

var totalExpenses = 0;
var totalIncomes = 0;

var Expense = function (id = 0, amount, date, category, paymentMethod, comment = "-") {
	this.id = id;
	this.amount = amount;
	this.date = date;
	this.category = category;
	this.paymentMethod = paymentMethod;
	this.comment = comment;
};

var expenses = new Array();

expenses.push(new Expense(0, 560, "2020-05-06", "Wycieczka", "Gotówka"));
expenses.push(new Expense(1, 40, "2015-12-05", "Jedzenie", "Gotówka", "Głodny był"));
expenses.push(new Expense(2, 460, "2018-11-12", "Mieszkanie", "Karta debetowa"));
expenses.push(new Expense(3, 100.01, "2020-01-22", "Higiena", "Karta kredytowa"));
expenses.push(new Expense(4, 20, "2020-05-06", "Transport", "Gotówka"));
expenses.push(new Expense(5, 3, "2020-04-06", "Rozrywka", "Gotówka"));
expenses.push(new Expense(6, 23, "2020-05-26", "Ubranie", "Gotówka"));

var Income = function (id = 0, amount, date, category, comment = "-") {
	this.id = id;
	this.amount = amount;
	this.date = date;
	this.category = category;
	this.comment = comment;
};

var incomes = new Array();

incomes.push(new Income(0, 6650, "2020-05-06", "Wynagrodzenie"));
incomes.push(new Income(1, 60, "2015-12-05", "Odsetki bankowe"));
incomes.push(new Income(2, 80, "2018-11-12", "Sprzedaż na allegro"));
incomes.push(new Income(3, 100.09, "2020-01-22", "Inne", "Napiwek"));


function printIncomes()
{
	totalIncomes = 0;
	
	var div = '<table class="table table-sm  table-striped table-success text-center"><thead><tr><th scope="col" colspan="3">Przychody</th></tr><tr><th scope="col">Lp.</th><th> <scope="col">Kategoria</th><th scope="col">Kwota</th></tr></thead><tbody>';
	
	for(i=0; i<incomes.length; i++)
	{
		div += '<tr><th scope="row">'+(i+1)+'</th><td>' + incomes[i].category + '</td><td>' + incomes[i].amount + '</td></tr>' ;
		totalIncomes += incomes[i].amount;
	}
	
	div += '</tbody><tbody class="font-weight-bold"><tr><td></td><td class="sum">Suma:</td><td class="sum">' + totalIncomes + ' zł</td></tr>' ;
	div += "</tbody></table>";
	
	$('#incomes').html(div);
}

function printExpenses()
{	
	totalExpenses = 0;
	
	var div = '<table class="table table-sm table-striped table-secondary text-center"><thead><tr><th scope="col" colspan="3">Wydatki</th></tr><tr><th scope="col">Lp.</th><th scope="col">Kategoria</th><th scope="col">Kwota</th></tr></thead><tbody>';
	
	for(i=0; i<expenses.length; i++)
	{
		div += '<tr><th scope="row">'+(i+1)+'</th><td>' + expenses[i].category + '</td><td>' + expenses[i].amount + '</td></tr>' ;
		totalExpenses += expenses[i].amount;
	}
	
	div += '</tbody><tbody class="font-weight-bold"><tr><td></td><td class="sum">Suma:</td><td class="sum">' + totalExpenses + ' zł</td></tr>' ;
	div += "</tbody></table>";
	
	$('#expenses').html(div);
	// $('#expenses table').tablesorter({sortList: [[1,1], [0,0]]});
}

function printBalance()
{
	var balance = totalIncomes - totalExpenses;
	var warning = 'Uff.. Żyjesz na krawędzi ;)';
	
	if(balance > 0)
	{
		warning = "Gratulacje. Świetnie zarządzasz finansami!";
		$('#balance').css('color', 'none');
	}
	else if (balance < 0)
	{
		warning = "Uważaj, wpadasz w długi!";
		$('#balance').css('color', 'red');
	}
	
	var div = '<table class="table table-sm table-striped table-warning  text-center font-weight-bold"><tr><td class="sum">Bilans:</td><td class="sum">' + balance + ' zł</td></tr><tr><td colspan="2">' + warning +'</td></tr></table>';
	
	$('#balance').html(div);
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

function printIncomesDetailed()
{
	totalIncomes = 0;
	
	var div = '<form><table class="table table-sm table-striped table-success text-center"><thead><tr><th scope="col" colspan="6">Szczegółowe zestawienie przychodów</th></tr><tr><th scope="col">Lp.</th><th><scope="col">Data</th><th><scope="col">Kwota</th><th><scope="col">Kategoria</th><th scope="col">Komentarz</th><th scope="col">Usuń</th></tr></thead><tbody>';
	
	for(i=0; i<incomes.length; i++)
	{
		div += '<tr><th scope="row">'+(i+1)+'</th><td>' + incomes[i].date + '</td><td>' + incomes[i].amount + '</td><td>' + incomes[i].category + '</td><td>' + incomes[i].comment + '</td><td><button class="btn btn-sm btn-delete" type="submit" name="deleteIncome" value=' + incomes[i].id + '><i class="icon-cancel"></i></button></td></tr>' ;
	}
	
	div += "</tbody></table></form>";
	
	$('#incomesDetailed').html(div);
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