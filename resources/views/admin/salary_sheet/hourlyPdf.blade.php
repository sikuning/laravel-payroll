
<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>Salary Payslip</title>
		<meta charset="utf-8">
	</head>
	<style>
		table {
			margin: 0 0 40px 0;
			width: 100%;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
			display: table;
			border-spacing: 0px;
		}
		table, td, th {border: 1px solid #ddd;}
		td{padding: 3px;}
		th{padding: 3px;}
		.text-center{
			text-align: center;
		}
		.companyAddress{
			width: 367px;
			margin: 0 auto;
            text-align: center;
		}
        h3{
            margin: 0 0 20px;
        }
        p{
            margin: 0 0 10px;
        }
		.container {
			padding-right: 15px;
			padding-left: 15px;
			margin-right: auto;
			margin-left: auto;
			width: 95%;
		}
		.row {
			margin-right: -15px;
			margin-left: -15px;
		}
		.col-md-6 {
			width: 49%;
			float: left;
			padding-right: .5%;
			padding-left: .5%;
		}
		.div1{
			position: relative;
		}
		.div2{
			position: absolute;
			width: 100%;
			border: 1px solid;
			padding: 30px 12px 0px 12px;
		}
		.col-md-4 {
			width: 33.33333333%;
			float: left;
		}
		.clearFix{
			clear:both;
		}
		.padding{
			margin-bottom: 32px;

		}
	</style>
	<body>
	<div class="container">
		<div class="row">
			<div class="companyAddress">
				<div class="headingStyle">
					<h3 style="margin:0;">{{$siteInfo->com_name}}</h3>
                    <p>{{$siteInfo->address}}</p>
				</div>
				<h3>Salary Slip</h3>
			</div>
			<div class="div1">
				<div class="div2">
					<div class="clearFix">
						<div class="col-md-6">
							<table >
								<tbody>
								<tr>
									<td>Name :</td>
									<td ><b>{{$salaryDetails->first_name}} {{$salaryDetails->last_name}}</b></td>
								</tr>
								<tr>
									<td>Department :</td>
									<td><b>{{$salaryDetails->department}}</b></td>
								</tr>
								<tr>
									<td>Designation :</td>
									<td><b>{{$salaryDetails->designation}}</b></td>
								</tr>
								<tr>
									<td>Total Working Hours :  </td>
									<td> <b>{{$salaryDetails->working_hour}}</b></td>
								</tr>
								<tr>
									<td>Hourly Rate  :  </td>
									<td><b>{{$salaryDetails->hourly_rate}}</b></td>
								</tr>
								<tr>
									<td> Net Salary to be Paid :  </td>
									<td style="background: #ddd"><b>{{number_format($salaryDetails->net_salary)}} </td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="col-md-6">
							<table class="table">
								<tbody>
								<tr>
									<td >No. :  </td>
									<td><b>{{$salaryDetails->id}}</b></td>
								</tr>
								<tr>
									<td>Month :   </td>
									<td> <b>{{date('M Y',strtotime($salaryDetails->month))}}</b></td>
								</tr>
								<tr>
									<td>Date : </td>
									<td><b>{{date(" d-M-Y", strtotime(date('Y-m-d')))}} </b></td>
								</tr>
								
								</tbody>
							</table>
						</div>
					</div>
					<div class="clearFix padding">
						<div class="col-md-6" style="text-align: center;">
							<strong>Adminstrator Signature</strong>
						</div>
						<div class=" col-md-6" style="text-align: center;">
							<strong>Employee Signature</strong>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>


