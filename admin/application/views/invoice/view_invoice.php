<!-- begin markup -->
<div class="well">
	<a href="" class="btn btn-success">Download PDF</a>
	<a href="" class="btn btn-info">Email</a>
</div>
<div id="invoice" class="new">


	<div class="this-is">
		<strong>Invoice</strong>
	</div><!-- invoice headline -->


	<header id="header">
		<div class="invoice-intro">
			<h1>Company Name</h1>
		</div>

		<dl class="invoice-meta">
			<dt class="invoice-number">Invoice #</dt>
			<dd><?php echo $invoice['invoice_id']; ?></dd>
			<dt class="invoice-date">Date of Invoice</dt>
			<dd><?php echo $invoice['invoice_date']; ?></dd>
			<dt class="invoice-due">Due Date</dt>
			<dd><?php echo $invoice['invoice_due_date']; ?></dd>
		</dl>
	</header>
	<!-- e: invoice header -->


	<section id="parties">

		<div class="invoice-to">
			<h4>Invoice To:</h4>
			<div id="hcard-Hiram-Roth" class="vcard">
				<a class="url fn" href="http://memory-alpha.org">Hiram Roth</a>
				<div class="org">United Federation of Planets</div>
				<a class="email" href="mailto:president.roth@ufop.uni">president.roth@ufop.uni</a>
				
				<div class="adr">
					<div class="street-address">2269 Elba Lane</div>
					<span class="locality">Paris</span>
					<span class="country-name">France</span>
				</div>

				<div class="tel">888-555-2311</div>
			</div><!-- e: vcard -->
		</div><!-- e invoice-to -->


		<!--<div class="invoice-from">
			<h2>Invoice From:</h2>
			<div id="hcard-Admiral-Valdore" class="vcard">
				<a class="url fn" href="http://memory-alpha.org">Admiral Valdore</a>
				<div class="org">Romulan Empire</div>
				<a class="email" href="mailto:admiral.valdore@theempire.uni">admiral.valdore@theempire.uni</a>
				
				<div class="adr">
					<div class="street-address">5151 Pardek Memorial Way</div>
					<span class="locality">Krocton Segment</span>
					<span class="country-name">Romulus</span>
				</div>

				<div class="tel">000-555-9988</div>
			</div>
		</div>
		-->


		<div class="invoice-status">
			<h4>Invoice Status</h4>
			<strong>Invoice is <em><?php if($invoice['invoice_status'] == 'unpaid'){ echo '<span style="color: #C5253B;">'.$invoice['invoice_status'].'</span>'; } if($invoice['invoice_status'] == 'paid'){ echo '<span style="color: green;">'.$invoice['invoice_status'].'</span>'; }?></em></strong>
		</div><!-- e: invoice-status -->

	</section><!-- e: invoice partis -->


	<section class="invoice-financials">

		<div class="invoice-items">
			<table>
				<caption>Your Invoice</caption>
				<thead>
					<tr>
						<th>Item &amp; Description</th>
						<th>Quantity</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>Device</th>
						<td>100</td>
						<td>&pound;<?php echo $invoice['invoice_amount']; ?></td>
					</tr>
					
				</tbody>
				
			</table>
		</div><!-- e: invoice items -->


		<div class="invoice-totals">
			<table>
				<caption>Totals:</caption>
				<tbody>
					<tr>
						<th>Subtotal:</th>
						<td></td>
						<td>&pound;<?php echo $invoice['invoice_amount']; ?></td>
					</tr>
					<tr>
						<th>Surcharge @ 3%</th>
						<td></td>
						<td>&pound;<?php $percent = '0.03'; echo sprintf('%.2f',$invoice['invoice_amount'] * $percent)?></td>
					</tr>
					<tr>
						<th>Total:</th>
						<td></td>
						<td>&pound;<?php  
$p=$invoice['invoice_amount'] * $percent;
printf("%.2f", $invoice['invoice_amount'] + $p);

?></td>
					</tr>
				</tbody>
			</table>

			<div class="invoice-pay">
				<h5>Pay with...</h5>
				<ul>
					<li>
						<a href="#">SagePay</a>
					</li>
				</ul>
			</div>
		</div><!-- e: invoice totals -->


		<div class="invoice-notes">
			<h6>Notes &amp; Information:</h6>
		
		</div><!-- e: invoice-notes -->

	</section><!-- e: invoice financials -->



</div><!-- e: invoice -->