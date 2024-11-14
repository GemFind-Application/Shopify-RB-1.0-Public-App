<?php
defined('BASEPATH') or exit('No direct script access allowed');

$store_token = $access_token;
$footer_data['shop_access_token'] = $store_token;

if (empty($access_token)) {
	$store_token = $diamondconfigdata->shop_access_token;
}

// echo "<pre>"; print_r($diamondconfigdata); 

$request_headers = array(
	"X-Shopify-Access-Token:" . $store_token,
	"Content-Type:application/json"
);
file_put_contents('access_token.txt', $request_headers);
$result_charges = '';
$api_version = $this->config->item('shopify_api_version');
if ($recurring_charges_data->charge_id) {
	$get_charges_list_endpoint = $this->config->item('final_shop_url') . "/admin/api/" . $api_version . "/recurring_application_charges/" . $recurring_charges_data->charge_id . ".json";
	$result_charges = getCurlData($get_charges_list_endpoint, $request_headers);
}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/@shopify/polaris@4.5.0/styles.min.css" />
<style type="text/css">
	.columns {
		float: left;
		width: 33.3%;
		padding: 8px;
	}

	.price {
		list-style-type: none;
		border: 1px solid #eee;
		margin: 0;
		padding: 0;
		-webkit-transition: 0.3s;
		transition: 0.3s;
	}

	.price:hover {
		box-shadow: 0 8px 12px 0 rgba(0, 0, 0, 0.2)
	}

	.price .header {
		background-color: #111;
		color: white;
		font-size: 25px;
	}

	.price li {
		border-bottom: 1px solid #eee;
		padding: 20px;
		text-align: center;
	}

	.price .grey {
		background-color: #eee;
		font-size: 20px;
	}

	.button {
		background-color: #04AA6D;
		border: none;
		color: white;
		padding: 10px 25px;
		text-align: center;
		text-decoration: none;
		font-size: 18px;
	}

	@media only screen and (max-width: 600px) {
		.columns {
			width: 100%;
		}
	}

	#loader {
		display: none;
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		width: 100%;
		background: rgba(0, 0, 0, 0.75) url(<?php echo base_url() . "assets/images/loading2.gif"; ?>) no-repeat center center;
		z-index: 10000;
	}

	body {
		background-color: #fff;
	}

	.view-in-front,
	.view-in-front:active,
	.view-in-front:focus {
		box-sizing: border-box;
		position: relative;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 3.6rem;
		min-width: 3.6rem;
		margin: 0;
		padding: .7rem 1.6rem;
		border: .1rem solid var(--p-border, #c4cdd5);
		box-shadow: 0 1px 0 0 rgba(22, 29, 37, .05);
		border-radius: 3px;
		line-height: 1;
		color: #212b36;
		text-align: center;
		cursor: pointer;
		user-select: none;
		text-decoration: none;
		background: linear-gradient(180deg, #f9fafb, #f4f6f8);
		border-color: #c4cdd5;
	}

	.view-in-front:hover {
		box-shadow: 0 0 0 0 transparent, inset 0 1px 1px 0 rgba(99, 115, 129, .1), inset 0 1px 4px 0 rgba(99, 115, 129, .2);
		text-decoration: none;
	}

	.dearlercode-form,
	.upgrade_message {
		padding: 12px 30px
	}

	.alert {
		position: relative;
		padding: .75rem 1.25rem;
		margin-bottom: 1rem;
		border: 1px solid transparent;
		border-radius: .25rem;
	}

	.alert-success {
		color: #155724;
		background-color: #d4edda;
		border-color: #c3e6cb;
	}

	.form-body {
		padding: 2rem;
		background-color: #f4f4f4;
	}

	form#SystemOption {
		margin-bottom: 45px;
	}

	.form-actions.right {
		padding: 0 2rem;
	}

	#SubmitDiamondSetting {
		background: linear-gradient(180deg, #6371c7, #5563c1);
		border-color: #3f4eae;
		box-shadow: inset 0 1px 0 0 #6774c8, 0 1px 0 0 rgba(22, 29, 37, .05), 0 0 0 0 transparent;
		color: #fff;
		padding: 6px 25px;
	}

	#SubmitDiamondSetting:hover {
		background: linear-gradient(180deg, #5c6ac4, #4959bd);
		border-color: #3f4eae;
		color: #fff;
		text-decoration: none;
	}

	#SubmitSmtpSetting {
		background: linear-gradient(180deg, #6371c7, #5563c1);
		border-color: #3f4eae;
		box-shadow: inset 0 1px 0 0 #6774c8, 0 1px 0 0 rgb(22 29 37 / 5%), 0 0 0 0 transparent;
		color: #fff;
		padding: 6px 25px;
	}

	#SubmitSmtpSetting:hover {
		background: linear-gradient(180deg, #5c6ac4, #4959bd);
		border-color: #3f4eae;
		color: #fff;

	}

	.getting-started-banner {
		display: flex;
	}

	.getting-started-banner .getting-started-banner--image {
		width: 240px;
		height: auto;
		display: inline-flex;
		padding: 60px 30px;
		background-color: #F9FAFB;
		border: 1px solid #DFE3E8;
	}

	.getting-started-banner .getting-started-banner--image img {
		max-width: 100%;
		width: 100%;
	}

	.getting-started-banner .getting-started-banner--content {
		width: 80%;
		padding: 30px;
		background-color: #F9FAFB;
		border: 1px solid #DFE3E8;
	}

	.getting-started-banner .getting-started-banner--content .banner__title {
		font-size: 16px;
		line-height: 24px;
		color: #31373D;
		font-weight: 500;
	}

	.getting-started-banner .getting-started-banner--content .banner__content {
		font-size: 14px;
		line-height: 20px;
		color: #212B36;
		margin: 20px 0;
	}

	.Polaris-Button a,
	.Polaris-Banner__PrimaryAction a {
		text-decoration: none;
		color: #212b36;
	}

	.Polaris-Button a:hover,
	.Polaris-Banner__PrimaryAction a:hover {
		text-decoration: none;
	}

	.Polaris-Button:hover {
		background: linear-gradient(180deg, #f9fafb, #d7dadc);
		border-color: #c4cdd5;
	}

	#getting_started .Polaris-Layout__Section {
		padding-top: 35px;
		margin: 0;
		max-width: 100%;
	}

	#knowledge .Polaris-Layout__Section {
		margin: 0px;
	}

	.Polaris-Layout {
		margin: 0;
		padding-bottom: 40px;
	}

	#myTab {
		border: none;
	}

	.nav-tabs>li.nav-item>a.nav-link {
		border: none;
		border-radius: 4px 4px 4px 4px;
	}

	.nav-tabs>li.nav-item.active>a.nav-link,
	.nav-tabs>li.nav-item.active>a.nav-link:focus,
	.nav-tabs>li.nav-item.active>a.nav-link:hover {
		border: none;
		background: linear-gradient(180deg, #6371c7, #5563c1);
		border-color: #3f4eae;
		box-shadow: inset 0 1px 0 0 #6774c8, 0 1px 0 0 rgba(22, 29, 37, .05), 0 0 0 0 transparent;
		color: #fff;
	}

	.nav-tabs>li.nav-item>a.nav-link:hover {
		border: none;
		background: linear-gradient(180deg, #6371c7, #5563c1);
		border-color: #3f4eae;
		box-shadow: inset 0 1px 0 0 #6774c8, 0 1px 0 0 rgba(22, 29, 37, .05), 0 0 0 0 transparent;
		color: #fff;
	}

	.help-text {
		font-size: 29px;
		position: relative;
		display: inline-table;
		padding-top: 25px;
		padding-bottom: 25px;
		font-weight: 600;
	}

	li.Polaris-ResourceList__ItemWrapper {
		padding: 15px;
		border: 1px solid #ccc;
	}

	.Polaris-Layout__Section.help_center {
		padding-bottom: 35px;
	}

	.tab-content>.tab-pane {
		padding-top: 20px;
	}

	.quick_links {
		float: right !important;
		margin-right: 5px;
	}

	li.quick_links>a:active {
		margin-right: 2px;
	}

	.nav-tabs>li.quick_links>a {
		border-radius: 4px 4px 4px 4px;
		padding: .7rem 1.6rem;
		border: 1px solid #c4cdd5;
	}

	.card-header {
		font-size: 1rem;
		line-height: 1.5;
		color: #212529;
		text-align: left;
		font-family: "Roboto", sans-serif;
		font-weight: 400;
		box-sizing: border-box;
		margin-bottom: .25rem !important;
		box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12) !important;
		border-radius: 0;
		padding: 1rem 1.5rem;
		background: transparent;
		border: 0;
	}

	.card-header .mb-0 .btn.btn-link {
		width: 100%;
		text-align: left;
		font-weight: 600;
		color: #212b36;
		font-size: 16px;
	}

	.card-header .mb-0 .btn.btn-link:hover {
		text-decoration: none;
	}

	#accordion .card-body {
		text-align: left;
		font-family: "Roboto", sans-serif;
		box-sizing: border-box;
		flex: 1 1 auto;
		min-height: 1px;
		padding: 1.25rem;
		margin-bottom: .25rem !important;
		background-color: rgb(189 189 189 / 30%);
		padding-top: 1.5rem;
		padding-bottom: 1.5rem;
		border-radius: 0 !important;
		font-size: 1em;
		font-weight: 400;
		line-height: 1.7;
		border: 0;
	}

	.card-header .mb-0 .btn.btn-link:focus {
		outline: none;
		text-decoration: none;
	}

	.rotate-icon {
		float: right;
		font-size: 23px;
	}

	#accordion .card .card-header button:not(.collapsed) .rotate-icon {
		-webkit-transform: rotate(180deg);
		transform: rotate(180deg);
	}

	.field_usage_section {
		padding: 10px;
		line-height: 25px;
		color: black;
		border: 1px solid #ccc;
		transition: box-shadow .2s cubic-bezier(.64, 0, .35, 1);
		transition-delay: .1s;
		box-shadow: inset 0 3px 0 0 #47c1bf, inset 0 0 0 0 transparent, 0 0 0 1px rgba(63, 63, 68, .05), 0 1px 3px 0 rgba(63, 63, 68, .15);
		background-color: #eef9f9;
	}

	.field_item h3 {
		font-weight: 600;
	}

	.fieldtooltip {
		position: relative;
		display: inline-block;
		border-bottom: 1px dotted black;
		top: -23px;
		left: -133px;
	}

	.fieldtooltip .tooltiptext {
		visibility: hidden;
		width: 120px;
		background-color: #555;
		color: #fff;
		text-align: center;
		border-radius: 6px;
		padding: 5px 0;
		position: absolute;
		z-index: 1;
		bottom: 125%;
		left: 50%;
		margin-left: -60px;
		opacity: 0;
		transition: opacity 0.3s;
	}

	.fieldtooltip .tooltiptext::after {
		content: "";
		position: absolute;
		top: 100%;
		left: 50%;
		margin-left: -5px;
		border-width: 5px;
		border-style: solid;
		border-color: #555 transparent transparent transparent;
	}

	.gemfind_powered_by {
		float: right;
		width: 100%;
		text-align: right;
		display: block;
		margin-bottom: 30px;
		color: #000;
	}

	.gemfind_powered_by a {
		color: inherit;
	}

	.form-submitmsg {
		display: none;
	}

	.heading-customerform {
		font-size: 29px;
		position: relative;
		display: inline-table;
		padding-top: 25px;
		padding-bottom: 25px;
		font-weight: 600;
	}

	.frmcustomer .form-actions.right {
		margin-top: 15px;
		padding: 0 !important;
	}

	#SubmitCustomerInfo {
		background: linear-gradient(180deg, #6371c7, #5563c1);
		border-color: #3f4eae;
		box-shadow: inset 0 1px 0 0 #6774c8, 0 1px 0 0 rgb(22 29 37 / 5%), 0 0 0 0 transparent;
		color: #fff;
		padding: 6px 25px;
		margin: 15px;
	}

	.Polaris-Card__Section.plan_section input[type="text"] {
		background-color: white;
		color: #333333;
		border: 1px solid #d5d5d5;
		border-radius: 5px;
		padding: 10px 12px;
		width: calc(100% - 110px);
	}

	.Polaris-Card__Section.plan_section input[type="button"] {
		margin-left: 12px;
		background: #6371c7;
		border: 1px solid #c8c8c8;
		color: #fff;
		border-radius: 5px;
		padding: 10px 22px;
		font-size: 15px;
	}

	.Polaris-Card__Section.plan_section .order-summary__section table {
		width: 100%;
		border-top: 1px solid rgba(175, 175, 175, 0.34);
	}

	.Polaris-Card__Section.plan_section .tags-list {
		border-radius: 4px;
		background-color: rgba(113, 113, 113, 0.11);
		color: #717171;
		padding: 10px;
		display: table;
		margin-bottom: 12px;
		font-size: 15px;
	}

	.Polaris-Card__Section.plan_section .tags-list .reduction-code__text {
		margin: 0 10px 0 5px;
	}

	.Polaris-Card__Section.plan_section .activate_plan {
		float: right;
		margin: 15px 0;
		font-size: 17px;
		padding: 10px;
		border-radius: 5px;
		background: #6371c7;
		color: #fff;
	}

	.Polaris-Card__Section.plan_section .order-summary__section th {
		text-align: left;
		width: 50%;
		color: #535353;
		font-weight: 400;
		padding-top: 0.75em;
	}

	.Polaris-Card__Section.plan_section .order-summary__section td {
		vertical-align: bottom;
		padding-left: 1.5em;
		text-align: right;
		white-space: nowrap;
		color: #535353;
		font-weight: 600
	}

	.Polaris-Card__Section.plan_section .total-line-table__tbody+.total-line-table__footer .total-line:first-child th::before,
	.Polaris-Card__Section.plan_section .total-line-table__tbody+.total-line-table__footer .total-line:first-child td::before {
		content: '';
		position: absolute;
		top: 1.5em;
		left: 0;
		width: 100%;
		height: 1px;
		background-color: rgba(175, 175, 175, 0.34);
	}

	.Polaris-Card__Section.plan_section .total-line-table__tbody+.total-line-table__footer td,
	.Polaris-Card__Section.plan_section .total-line-table__tbody+.total-line-table__footer th {
		position: relative;
		padding-top: 3em;
	}

	.Polaris-Card__Section.plan_section .visually-hidden {
		border: 0;
		clip: rect(0, 0, 0, 0);
		clip: rect(0 0 0 0);
		width: 2px;
		height: 2px;
		margin: -2px;
		overflow: hidden;
		padding: 0;
		position: absolute;
		white-space: nowrap;
	}

	.Polaris-Card__Section.plan_section .order-summary__section {
		padding: 20px 0;
	}

	.Polaris-Card__Section.plan_section i.fa.fa-tag {
		transform: scaleX(-1);
	}

	.reduction-code {
		margin-left: 5px;
	}

	.alert-status-container {
		display: none;
		opacity: 1 !important
	}

	.subscribe-btn {
		border: none;
		background: linear-gradient(180deg, #6371c7, #5563c1);
		border-color: #3f4eae;
		box-shadow: inset 0 1px 0 0 #6774c8, 0 1px 0 0 rgb(22 29 37 / 5%), 0 0 0 0 transparent;
		color: #fff;
		border-radius: 5px;
	}

	.modal-header .close {
		margin-top: -10px;
	}

	#show-filter-info .modal-dialog {
		white-space: nowrap;
	}

	.info {
		background-color: #ddd;
		/*border-left: 4px solid #777;*/
	}

	.ji-certified {
		height: 20px;
	}

	.col-ji-certified {
		display: flex;
		margin: 20px 0;
	}

	.form-body input[type=checkbox] {
		width: 7%;
		margin-top: 0;
	}

	.form-group .col-md-6 {
		margin: 7px 0;
	}

	.gf-required {
		color: red;
	}

	#Banner30Content {
		box-shadow: inset 0 0 0 0 transparent, 0 0 0 1px rgba(63, 63, 68, .05), 0 1px 3px 0 rgba(63, 63, 68, .15);
		background-color: #eef9f9;
		padding: 10px;
		margin-bottom: 15px;
	}

	#Banner30Content p strong {
		font-size: 16px;
	}
</style>

<script type="text/javascript">
	setTimeout(function() {
		$(".alert").fadeOut();
	}, 5000);
</script>
<div class="dearlercode-form">
	<?php if ($this->session->flashdata('SystemOptionMSG')) { ?>
		<div class="alert alert-success">
			<strong>Success!</strong> <?php echo $this->session->flashdata('SystemOptionMSG'); ?>
		</div>
	<?php } ?>

	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item hide">
			<a class="nav-link hide" id="started-tab" data-toggle="tab" href="#getting_started" role="tab" aria-controls="getting_started" aria-selected="true">Getting Started</a>
		</li>

		<?php if ($recurring_charges_data->charge_id != '' &&  $recurring_charges_data->status == 'active') { ?>

			<li class="nav-item active">
				<a class="nav-link active" id="setting-tab" data-toggle="tab" href="#setting" role="tab" aria-controls="setting" aria-selected="false">Settings</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="pricingplan-tab" data-toggle="tab" href="#pricingplan" role="tab" aria-controls="pricingplan" aria-selected="false">My Plan</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="smtpconfig-tab" data-toggle="tab" href="#smtpconfig" role="tab" aria-controls="smtpconfig" aria-selected="false">SMTP Configuration</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" id="knowledge-tab" data-toggle="tab" href="#knowledge" role="tab" aria-controls="knowledge" aria-selected="false">Knowledge Base</a>
			</li>

			<li class="quick_links">
				<a href="<?php echo $this->config->item('final_shop_url') . "/admin/apps/"; ?>" target="_top" rel="noopener noreferrer" class="view-in-front">Back to Apps Listing</a>
			</li>
			<?php if ($diamondconfigdata->dealerid) { ?>
				<li class="quick_links">
					<a href="<?php echo $this->config->item('final_shop_url') . "/apps/ringbuilder/settings/"; ?>" target="_blank" class="view-in-front">View in Frontend</a>
				</li>
			<?php } ?>

		<?php } else { ?>

			<li class="nav-item active" style="display: <?php echo isset($customer) && $customer != "" ? 'block' : 'none' ?>">
				<a class="nav-link active" id="pricingplan-tab" data-toggle="tab" href="#pricingplan" role="tab" aria-controls="pricingplan" aria-selected="false">My Plan</a>
			</li>

		<?php } ?>


	</ul>

	<div class="tab-content" id="myTabContent">
		<div class="tab-pane" id="getting_started" role="tabpanel" aria-labelledby="started-tab">
			<div class="Polaris-Layout">
				<div class="Polaris-Layout__Section">
					<div class="getting-started-banner">
						<div class="getting-started-banner--image">
							<img src="<?php echo base_url(); ?>/assets/images/getting-started.png">
						</div>
						<div class="getting-started-banner--content">
							<h3 class="banner__title">Next Steps for Getting Started with GemFind RingBuilder</h3>
							<p>&nbsp;</p>
							<ul>
								<li>Your RingBuilder app requires a Jewelcloud account with GemFind.</li>
								<li>Please click the Settings tab and fill out the application so we can create your Jewelcloud account.</li>
								<li>Once your Jewelcloud account has been activated our support team will email your Jewelcloud account information and instructions for selecting your diamond vendors and setting your markups.</li>
							</ul>

							<p>&nbsp;</p>
							<p>Got questions? Contact us at <a href="mailto:sales@gemfind.com" target="_blank">sales@gemfind.com</a> or <a href="tel:800-373-4373" target="_blank">800-373-4373</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="knowledge" role="tabpanel" aria-labelledby="knowledge-tab">
			<div class="Polaris-Layout">
				<div class="Polaris-Layout__Section help_center">
					<span class="help-text">Help Center</span>
					<div class="Polaris-Banner Polaris-Banner--statusInfo Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner28Heading" aria-describedby="Banner28Content">
						<div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorTealDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
									<path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m0-4.1a1.1 1.1 0 1 0 .001 2.201A1.1 1.1 0 0 0 10 13.9M10 4C8.625 4 7.425 5.161 7.293 5.293A1.001 1.001 0 0 0 8.704 6.71C8.995 6.424 9.608 6 10 6a1.001 1.001 0 0 1 .591 1.808C9.58 8.548 9 9.616 9 10.737V11a1 1 0 1 0 2 0v-.263c0-.653.484-1.105.773-1.317A3.013 3.013 0 0 0 13 7c0-1.654-1.346-3-3-3"></path>
								</svg></span></div>
						<div class="Polaris-Banner__ContentWrapper">
							<div class="Polaris-Banner__Heading" id="Banner28Heading">
								<p class="Polaris-Heading">We’d love to hear from you</p>
							</div>
							<div class="Polaris-Banner__Content" id="Banner28Content">
								<p>Need help? Schedule a Free Consultation by clicking below link</p>
								<div class="Polaris-Banner__Actions">
									<div class="Polaris-ButtonGroup">
										<div class="Polaris-ButtonGroup__Item">
											<div class="Polaris-Banner__PrimaryAction"><a target="_blank" class="Polaris-Button Polaris-Button--outline" href="https://gemfind.com/free-consultation/" rel="noopener noreferrer" data-polaris-unstyled="true"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Free Consultation</span></span></a></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if ($recurring_charges_data->charge_id != '' &&  $recurring_charges_data->status == 'active') { ?>
			<div class="tab-pane active" id="setting" role="tabpanel" aria-labelledby="setting-tab">

				<div class="tab-pane" id="getting_started" role="tabpanel" aria-labelledby="started-tab">
					<div class="Polaris-Layout">
						<div class="Polaris-Layout__Section">
							<div class="getting-started-banner">
								<div class="getting-started-banner--image">
									<img src="<?php echo base_url(); ?>/assets/images/getting-started.png">
								</div>
								<div class="getting-started-banner--content">
									<h3 class="banner__title">Next Steps for Getting Started with GemFind RingBuilderⓇ</h3>
									<p>&nbsp;</p>
									<ul>
										<li>Thank you for installing The RingBuilderⓇ application powered by GemFind. You will receive an email from our Support Team shortly.</li>
										<li style="color: red"> <strong> Please provide collaborator access of the store to GemFind Support Team once you received the email from Shopify. </strong></li>
										<li>You will receive an email from our Support Team with your unique Jewelcloud ID once your account is setup. This can take up to one business day.
											The default JewelCloud Account ID - 1089 and Admin Email Address are for demonstration purposes only.</li>
									</ul>

									<p>&nbsp;</p>
									<p>Got a question? Contact us at <a href="mailto:support@gemfind.com" target="_blank">support@gemfind.com</a> or <a href="tel:+19497527710" target="_blank">+1-949-752-7710.</a></p></a></p>
								</div>
							</div>
						</div>

					</div>
				</div>
				<form action="" method="post" id="SystemOption" name="SystemOption" class="form-horizontal">
					<input type="hidden" name="sp_access_token" value="<?php echo $store_token ?>">
					<div class="form-body">

						<div class="form-group">
							<div class="col-md-6">
								<label class="control-label">JewelCloud Account ID</label>
								<input type="text" name="dealerid" value="<?php echo $diamondconfigdata->dealerid; ?>" class="form-control" maxlength="255">
							</div>
							<div class="col-md-6">
								<label class="control-label">Admin Email Address</label>
								<input type="text" name="admin_email_address" value="<?php echo $diamondconfigdata->admin_email_address; ?>" class="form-control" maxlength="255">
							</div>
						</div>

						<div class="form-group hide">
							<div class="col-md-6">
								<label class="control-label">Dealer Auth API</label>
								<input type="text" name="dealerauthapi" value="<?php echo ($diamondconfigdata->dealerauthapi ? $diamondconfigdata->dealerauthapi : "http://api.jewelcloud.com/api/RingBuilder/AccountAuthentication"); ?>" class="form-control" maxlength="255" readonly>
							</div>
							<div class="col-md-6">
								<label class="control-label">Navigation Api</label>
								<input type="text" name="navigationapi" value="<?php echo ($diamondconfigdata->navigationapi ? $diamondconfigdata->navigationapi : "http://api.jewelcloud.com/api/RingBuilder/GetNavigation?"); ?>" class="form-control" maxlength="255" readonly>
							</div>
							<div class="col-md-6">
								<label class="control-label">Navigation RB Api</label>
								<input type="text" name="navigationapirb" value="<?php echo ($diamondconfigdata->navigationapirb ? $diamondconfigdata->navigationapirb : "http://api.jewelcloud.com/api/RingBuilder/GetRBNavigation?"); ?>" class="form-control" maxlength="255" readonly>

							</div>
						</div>

						<div class="form-group hide">
							<div class="col-md-6">
								<label class="control-label">Ring's Filters API URL</label>
								<input type="text" name="ringfiltersapi" value="<?php echo ($diamondconfigdata->ringfiltersapi ? $diamondconfigdata->ringfiltersapi : "http://api.jewelcloud.com/api/RingBuilder/GetFilters?"); ?>" class="form-control" maxlength="255" readonly>
							</div>
							<div class="col-md-6">
								<label class="control-label">Mountinglist API URL</label>
								<input type="text" name="mountinglistapi" value="<?php echo ($diamondconfigdata->mountinglistapi ? $diamondconfigdata->mountinglistapi : "http://api.jewelcloud.com/api/RingBuilder/GetMountingList?"); ?>" class="form-control" maxlength="255" readonly>
							</div>
						</div>

						<div class="form-group hide">
							<div class="col-md-6">
								<label class="control-label">MountingDetail API URL(Fancy Diamonds)</label>
								<input type="text" name="mountinglistapifancy" value="<?php echo ($diamondconfigdata->mountinglistapifancy ? $diamondconfigdata->mountinglistapifancy : "http://api.jewelcloud.com/api/RingBuilder/GetMountingDetail?"); ?>" class="form-control" maxlength="255" readonly>
							</div>
							<div class="col-md-6">
								<label class="control-label">Ring's Style Settings API URL</label>
								<input type="text" name="ringstylesettingapi" value="<?php echo ($diamondconfigdata->ringstylesettingapi ? $diamondconfigdata->ringstylesettingapi : "http://api.jewelcloud.com/api/RingBuilder/GetStyleSetting?"); ?>" class="form-control" maxlength="255" readonly>
							</div>
						</div>

						<div class="form-group hide">
							<div class="col-md-6">
								<label class="control-label">Filter API</label>
								<input type="text" name="filterapi" value="<?php echo ($diamondconfigdata->filterapi ? $diamondconfigdata->filterapi : "http://api.jewelcloud.com/api/RingBuilder/GetDiamondFilter?"); ?>" class="form-control" maxlength="255" readonly>
							</div>
							<div class="col-md-6">
								<label class="control-label">Filter API Fancy</label>
								<input type="text" name="filterapifancy" value="<?php echo ($diamondconfigdata->filterapifancy ? $diamondconfigdata->filterapifancy : "http://api.jewelcloud.com/api/RingBuilder/GetColorDiamondFilter?"); ?>" class="form-control" maxlength="255" readonly>
							</div>
						</div>

						<div class="form-group hide">
							<div class="col-md-6">
								<label class="control-label">Diamond List API</label>
								<input type="text" name="diamondlistapi" value="<?php echo ($diamondconfigdata->diamondlistapi ? $diamondconfigdata->diamondlistapi : "http://api.jewelcloud.com/api/RingBuilder/GetDiamond?"); ?>" class="form-control" maxlength="255" readonly>
							</div>
							<div class="col-md-6">
								<label class="control-label">Diamond List API Fancy</label>
								<input type="text" name="diamondlistapifancy" value="<?php echo ($diamondconfigdata->diamondlistapifancy ? $diamondconfigdata->diamondlistapifancy : "http://api.jewelcloud.com/api/RingBuilder/GetColorDiamond?"); ?>" class="form-control" maxlength="255" readonly>
							</div>
						</div>

						<div class="form-group hide">
							<div class="col-md-4">
								<label class="control-label">Diamond Shape API</label>
								<input type="text" name="diamondshapeapi" value="<?php echo ($diamondconfigdata->diamondshapeapi ? $diamondconfigdata->diamondshapeapi : "http://api.jewelcloud.com/api/ringbuilder/GetShapeByColorFilter?"); ?>" class="form-control" maxlength="255" readonly>
							</div>
							<div class="col-md-4">
								<label class="control-label">Diamond Detail API</label>
								<input type="text" name="diamonddetailapi" value="<?php echo ($diamondconfigdata->diamonddetailapi ? $diamondconfigdata->diamonddetailapi : "http://api.jewelcloud.com/api/RingBuilder/GetDiamondDetail?"); ?>" class="form-control" maxlength="255" readonly>
							</div>
							<div class="col-md-4">
								<label class="control-label">Style Setting API</label>
								<input type="text" name="stylesettingapi" value="<?php echo ($diamondconfigdata->stylesettingapi ? $diamondconfigdata->stylesettingapi : "http://api.jewelcloud.com/api/RingBuilder/GetStyleSetting?"); ?>" class="form-control" maxlength="255" readonly>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6">
								<label class="control-label">Enable A Hint</label>
								<select name="enable_hint" id="enable_hint" class="form-control">
									<option value="true" <?php echo ($diamondconfigdata->enable_hint == "true") ? "selected" : "" ?>>Yes</option>
									<option value="false" <?php echo ($diamondconfigdata->enable_hint == "false") ? "selected" : "" ?>>No</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="control-label">Enable Email A Friend</label>
								<select name="enable_email_friend" id="enable_email_friend" class="form-control">
									<option value="true" <?php echo ($diamondconfigdata->enable_email_friend == "true") ? "selected" : "" ?>>Yes</option>
									<option value="false" <?php echo ($diamondconfigdata->enable_email_friend == "false") ? "selected" : "" ?>>No</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6">
								<label class="control-label">Enable Schedule A Viewing</label>
								<select name="enable_schedule_viewing" id="enable_schedule_viewing" class="form-control">
									<option value="true" <?php echo ($diamondconfigdata->enable_schedule_viewing == "true") ? "selected" : "" ?>>Yes</option>
									<option value="false" <?php echo ($diamondconfigdata->enable_schedule_viewing == "false") ? "selected" : "" ?>>No</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="control-label">Enable Request More Info</label>
								<select name="enable_more_info" id="enable_more_info" class="form-control">
									<option value="true" <?php echo ($diamondconfigdata->enable_more_info == "true") ? "selected" : "" ?>>Yes</option>
									<option value="false" <?php echo ($diamondconfigdata->enable_more_info == "false") ? "selected" : "" ?>>No</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-4">
								<label class="control-label">Enable Print</label>
								<select name="enable_print" id="enable_print" class="form-control">
									<option value="true" <?php echo ($diamondconfigdata->enable_print == "true") ? "selected" : "" ?>>Yes</option>
									<option value="false" <?php echo ($diamondconfigdata->enable_print == "false") ? "selected" : "" ?>>No</option>
								</select>
							</div>
							<div class="col-md-4">
								<label class="control-label">Enable Admin Notification</label>
								<select name="enable_admin_notification" id="enable_admin_notification" class="form-control">
									<option value="true" <?php echo ($diamondconfigdata->enable_admin_notification == "true") ? "selected" : "" ?>>Yes</option>
									<option value="false" <?php echo ($diamondconfigdata->enable_admin_notification == "false") ? "selected" : "" ?>>No</option>
								</select>
							</div>
							<div class="col-md-4">
								<label class="control-label">Show Info Box?</label>
								<select name="show_filter_info" id="show_filter_info" class="form-control">
									<option value="true" <?php echo ($diamondconfigdata->show_filter_info == "true") ?  "selected" : "" ?>>Yes</option>
									<option value="false" <?php echo ($diamondconfigdata->show_filter_info == "false") ? "selected" : "" ?>>No</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-4">
								<label class="control-label">Diamond Listing Default View</label>
								<select name="default_viewmode" id="default_viewmode" class="form-control">
									<option value="list" <?php echo ($diamondconfigdata->default_viewmode == "list") ? "selected" : "" ?>>List</option>
									<option value="grid" <?php echo ($diamondconfigdata->default_viewmode == "grid") ? "selected" : "" ?>>Grid</option>
								</select>
							</div>
							<div class="col-md-4">
								<label class="control-label">Show Powered By GemFind?</label>
								<select name="show_powered_by" id="show_powered_by" class="form-control">
									<option value="true" <?php echo ($diamondconfigdata->show_powered_by == "true") ?  "selected" : "" ?>>Yes</option>
									<option value="false" <?php echo ($diamondconfigdata->show_powered_by == "false") ? "selected" : "" ?>>No</option>
								</select>
							</div>
							<!-- <div class="col-md-4">
									<label class="control-label">Enable Sticky Header?</label>
									<select name="enable_sticky_header" id="enable_sticky_header" class="form-control">
										<option value="true" <?php //echo ($diamondconfigdata->enable_sticky_header == "true") ?  "selected" : "" 
																?>>Yes</option>
										<option value="false" <?php //echo ($diamondconfigdata->enable_sticky_header == "false") ? "selected" : "" 
																?>>No</option>
									</select>
								</div> -->

						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="control-label">Shop</label>
								<input type="text" name="shop" value="<?php echo $diamondconfigdata->shop; ?>" readonly class="form-control" maxlength="255">
							</div>
							<?php if ($recurring_charges_data->plan == 'Gemfind Tryon Plan' || $diamondconfigdata->shop == 'gemfind-app-store.myshopify.com') { ?>
								<div class="col-md-6">
									<label class="control-label">Display Tryon Button</label>
									<input type="hidden" name="shop" value="<?php echo $diamondconfigdata->shop; ?>">
									<input type="checkbox" name="display_tryon" value="1" <?php echo ($diamondconfigdata->display_tryon == 1 ? 'checked' : ''); ?> />
								</div>
							<?php } ?>
							<!-- <div class="col-md-6">
									<label class="control-label">Shop Logo URL</label>
									<input type="text" name="shop_logo" value="<?php //echo $diamondconfigdata->shop_logo; 
																				?>" class="form-control" maxlength="255">
								</div> -->
						</div>
						<div class="form-group">
							<div class="col-md-6 hide">
								<label class="control-label">Settings Carat Ranges</label>

								<textarea name="settings_carat_ranges" class="form-control">
								<?php
								if ($diamondconfigdata->settings_carat_ranges) {
									echo stripcslashes($diamondconfigdata->settings_carat_ranges);
								} else {
									echo '{"[.5ct - 4ct]":[0.5,4.0],"0.25":[0.2,0.3],"0.33":[0.31,0.4],"0.50":[0.41,0.65],"0.75":[0.66,0.85],"1.00":[0.86,1.14],"1.25":[1.15,1.40],"1.50":[1.41,1.65],"1.75":[1.66,1.85],"2.00":[1.86,2.15],"2.25":[2.16,2.45],"2.50":[2.46,2.65],"2.75":[2.66,2.85],"3.00":[2.85,3.25]}';
								}
								?>
								</textarea>
							</div>

							<div class="col-md-12">
								<i class="fa fa-info-circle" aria-hidden="true" onclick="showtoptext();"></i>
								<label class="control-label">Top TextArea:</label>

								<textarea class="form-control" id="announcement_text" name="announcement_text" maxlength="1000"><?php echo ($diamondconfigdata->announcement_text); ?></textarea>

							</div>
							<div class="col-md-12">
								<i class="fa fa-info-circle" aria-hidden="true" onclick="showringtoptext();"></i>
								<label class="control-label">Ring Details TextArea:</label>
								<textarea class="form-control" id="announcement_text_rbdetail" name="announcement_text_rbdetail" maxlength="1000"><?php echo ($diamondconfigdata->announcement_text_rbdetail); ?></textarea>
							</div>

							<div class="col-md-12">
								<label class="control-label">Ring Meta Title:</label>
								<textarea class="form-control" id="ring_meta_title" name="ring_meta_title" maxlength="1000"><?php echo ($diamondconfigdata->ring_meta_title); ?></textarea>

							</div>

							<div class="col-md-12">
								<label class="control-label">Ring Meta Description:</label>
								<textarea class="form-control" id="ring_meta_description" name="ring_meta_description" maxlength="1000"><?php echo ($diamondconfigdata->ring_meta_description); ?></textarea>

							</div>

							<!-- <div class="col-md-12">
									<label class="control-label">Ring Meta Keyword:</label>
									<textarea class="form-control" id="ring_meta_keywords" name="ring_meta_keywords" maxlength="1000"><?php //echo ($diamondconfigdata->ring_meta_keywords); 
																																		?></textarea>
									
								</div> -->

							<div class="col-md-12">
								<label class="control-label">Diamond Meta Title:</label>
								<textarea class="form-control" id="diamond_meta_title" name="diamond_meta_title" maxlength="1000"><?php echo ($diamondconfigdata->diamond_meta_title); ?></textarea>

							</div>

							<div class="col-md-12">
								<label class="control-label">Diamond Meta Description:</label>
								<textarea class="form-control" id="diamond_meta_description" name="diamond_meta_description" maxlength="1000"><?php echo ($diamondconfigdata->diamond_meta_description); ?></textarea>

							</div>

							<!-- <div class="col-md-12">
									<label class="control-label">Diamond Meta Keyword:</label>
									<textarea class="form-control" id="diamond_meta_keyword" name="diamond_meta_keyword" maxlength="1000"><?php //echo ($diamondconfigdata->diamond_meta_keyword); 
																																			?></textarea>
									
								</div> -->

							<div class="col-md-6">
								<label class="control-label">Google reCaptcha Site Key</label>
								<input type="text" name="site_key" value="<?php echo $diamondconfigdata->site_key; ?>" class="form-control" maxlength="255">
							</div>

							<div class="col-md-6">
								<label class="control-label">Google reCaptcha Secret Key</label>
								<input type="text" name="secret_key" value="<?php echo $diamondconfigdata->secret_key; ?>" class="form-control" maxlength="255">
							</div>

							<div class="col-md-4">

								<label class="control-label"> Currency Symbol Position </label>

								<select name="price_row_format" id="price_row_format" class="form-control">

									<option value="left" <?php echo ($diamondconfigdata->price_row_format == "left") ? "selected" : "" ?>>Right</option>

									<option value="right" <?php echo ($diamondconfigdata->price_row_format == "right") ? "selected" : "" ?>>Left</option>

								</select>

							</div>

							<div class="col-md-4">
								<label class="control-label"> Set Settings Per Page </label>

								<select name="products_pp" id="products_pp" class="form-control">

									<option value="12" <?php echo ($diamondconfigdata->products_pp == "12") ? "selected" : "" ?>>Records Per Page: 12</option>

									<option value="24" <?php echo ($diamondconfigdata->products_pp == "24") ? "selected" : "" ?>>Records Per Page: 24</option>

									<option value="48" <?php echo ($diamondconfigdata->products_pp == "48") ? "selected" : "" ?>>Records Per Page: 48</option>

									<option value="99" <?php echo ($diamondconfigdata->products_pp == "99") ? "selected" : "" ?>>Records Per Page: 99</option>

								</select>
							</div>

							<div class="col-md-4">
								<label class="control-label">Set Sort Order</label>

								<select name="sorting_order" id="sorting_order" class="form-control">

									<option value="cost-l-h" <?php echo ($diamondconfigdata->sorting_order == "cost-l-h") ? "selected" : "" ?>> Price: Low - High </option>

									<option value="cost-h-l" <?php echo ($diamondconfigdata->sorting_order == "cost-h-l") ? "selected" : "" ?>> Price: High - Low </option>

								</select>

							</div>

							<div class="col-md-12">
								<!-- <i class="fa fa-info-circle" aria-hidden="true" onclick="showinfo();"></i> -->
								<label class="control-label">Note:</label>
								<div class="info">
									<p> If you want to display meta title and meta description for this tool than you should add this code in theme.liquid file before the tags. </p>
									<p> For Example : </p>
									<strong> For Title </strong>
									<p> <strong> {% unless template == blank %} </strong>
										<?php
										$tag = '<title>{{ seo_title | strip }}</title>';
										echo htmlentities($tag);
										?>
										<strong> {% endunless %} </strong>
									</p>

									<strong> For Description </strong>
									<p> <strong> {% unless template == blank %} </strong>
										<?php
										$tag1 = ' <meta name="description" content="{{ page_description | escape }}">';
										echo htmlentities($tag1);
										?>
										<strong> {% endunless %} </strong>
									</p>

								</div>
							</div>

						</div>
					</div>
					<div class="form-actions right">
						<input type="submit" name="SubmitDiamondSetting" id="SubmitDiamondSetting" class="btn green" value="Submit">
					</div>
				</form>
				<div class="field_usage_section">
					<div class="Polaris-Banner__Heading" id="Banner28Heading">
						<p class="Polaris-Heading">Need help? Below are the description of each field using in configuration.</p>
					</div>
					<ul>
						<li class="field_item">
							<h3>JewelCloud Acount ID </h3>
							<p>This is mandatory field. GemFind Support team will help you to get the JewelCloud Account ID.</p>
						</li>
						<li class="field_item">
							<h3>Admin Email Address </h3>
							<p>This is mandatory field. For Emailing purposes, application using this Email Address.</p>
						</li>
						<li class="field_item">
							<h3>Enable A Hint </h3>
							<p>Toggle to display "Drop A Hint Email" at frontend.</p>
						</li>
						<li class="field_item">
							<h3>Enable Email A Friend </h3>
							<p>Toggle to display "Email A Friend" at frontend.</p>
						</li>
						<li class="field_item">
							<h3>Enable Schedule A Viewing </h3>
							<p>Toggle to display "Schedule A Viewing" at frontend.</p>
						</li>
						<li class="field_item">
							<h3>Enable Request More Info </h3>
							<p>Toggle to display "Enable Request More Info" at frontend.</p>
						</li>
						<li class="field_item">
							<h3>Enable Print </h3>
							<p>Toggle to display "Print" at frontend.</p>
						</li>
						<li class="field_item">
							<h3>Enable Admin Notification </h3>
							<p>Toggle to receive the notification on Admin Email Address.</p>
						</li>
						<li class="field_item">
							<h3>Show Info Box? </h3>
							<p>Toggle to display "Help Text" at frontend.</p>
						</li>
						<li class="field_item">
							<h3>Show Powered By GemFind? </h3>
							<p>This will toggle the "Powered By GemFind" at the footer of the tool.</p>
						</li>
						<!-- <li class="field_item">
								<h3>Enable Sticky Header?</h3>
								<p>This will toggle the sticky table header at diamond listing page.</p>
							</li> -->
						<li class="field_item">
							<h3>Diamond Listing Default View </h3>
							<p>Decide to display "Dimaond Listing" or "Grid View". Bydefault it is List View.</p>
						</li>
						<!-- <li class="field_item">
								<h3>Shop</h3>
								<p>It is just information purpose that what is the current store URL we are using inside configuration</p>
							</li>
							<li class="field_item">
								<h3>Settings Carat Ranges</h3>
								<p>The field is used for setting's carat ranges</p>
							</li>
							<li class="field_item">
								<h3>Shop Logo URL</h3>
								<p>It will need to enter the current shop logo URL which will used in emails which will send to end-users and store admin.</p>
							</li> -->
					</ul>
				</div>


			</div>
			<?php
			$app_total_bacic = APP_TOTAL_CHARGE;
			$app_total_tryon = APP_TRYON_CHARGE;
			$charge_api_call = base_url() . "charge?" . $_SERVER['QUERY_STRING'] . "&code_access=" . $access_token;
			?>
		<?php }  ?>

		<?php
		$app_total_bacic = APP_TOTAL_CHARGE;
		$app_total_tryon = APP_TRYON_CHARGE;
		$charge_api_call = base_url() . "charge?" . $_SERVER['QUERY_STRING'] . "&code_access=" . $access_token;
		?>
		<div class="tab-pane active" id="pricingplan" role="tabpanel" aria-labelledby="pricingplan-tab">

			<?php if (isset($customer) && $customer != "") { ?>

				<div class="Polaris-Banner Polaris-Banner--statusInfo Polaris-Banner--withinPage" id="Banner30Content">
					<div class="Polaris-Banner__Ribbon">
						<span class="Polaris-Icon Polaris-Icon--colorTealDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop">
							<svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
								<path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m0-4.1a1.1 1.1 0 1 0 .001 2.201A1.1 1.1 0 0 0 10 13.9M10 4C8.625 4 7.425 5.161 7.293 5.293A1.001 1.001 0 0 0 8.704 6.71C8.995 6.424 9.608 6 10 6a1.001 1.001 0 0 1 .591 1.808C9.58 8.548 9 9.616 9 10.737V11a1 1 0 1 0 2 0v-.263c0-.653.484-1.105.773-1.317A3.013 3.013 0 0 0 13 7c0-1.654-1.346-3-3-3">
								</path>
							</svg>
						</span>
					</div>
					<div class="Polaris-Banner__ContentWrapper">
						<div class="Polaris-Banner__Heading">
							<p class="Polaris-Heading">Disclaimer</p>
						</div>
						<div class="Polaris-Banner__Content">
							<p>Please check the tool online to make sure it works for your online jewelry store. Once you have installed and activated, there will be NO refunds, since the account has to be setup and training needs to be provided. Here is a <a target=_blank href="https://gemfindapps.com/apps/ringbuilder/settings"> link </a> to our demo store, please check and make sure it meets your expectations. Contact us if you have any questions prior to activation at <a href="mailto:support@gemfind.com"> support@gemfind.com </a> or call <a href="tel:+19497527710"> +19497527710 </a>.</p>

						</div>
					</div>
				</div>

				<div class="Polaris-Layout">
					<div class="Polaris-Layout__Section">
						<?php if ($recurring_charges_data->charge_id == '' &&  $recurring_charges_data->status != 'active') { ?>
							<div class="Polaris-Card__Section plan_section">


								<div class="Polaris-Banner Polaris-Banner--statusInfo Polaris-Banner--withinContentContainer" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner8Heading" aria-describedby="Banner8Content">
									<div class="Polaris-Banner__Ribbon">
										<span class="Polaris-Icon Polaris-Icon--colorTealDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop">
											<svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
												<circle cx="10" cy="10" r="9" fill="currentColor"></circle>
												<path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m1-5v-3a1 1 0 0 0-1-1H9a1 1 0 1 0 0 2v3a1 1 0 0 0 1 1h1a1 1 0 1 0 0-2m-1-5.9a1.1 1.1 0 1 0 0-2.2 1.1 1.1 0 0 0 0 2.2"></path>
											</svg>
										</span>
									</div>
									<div>
										<div class="Polaris-Banner__Heading" id="Banner8Heading">
											<p class="Polaris-Heading">RingBuilderⓇ Powered By GemFind</p>
										</div>
										<div class="Polaris-Banner__Content" id="Banner8Content">

											<?php
											$app_total_charge = APP_TOTAL_CHARGE;
											$charge_api_call = base_url() . "charge?" . $_SERVER['QUERY_STRING'] . "&code_access=" . $access_token;
											?>
											<!--<p class="main-activate-link"><a href="<?php //echo $charge_api_call . "&price=" . $app_total_charge.'&plantype=basic'; 
																						?>" target="_blank" rel="noopener noreferrer">Activate</a></p>-->
											<p>
												Have a Coupon?<a class="button_discount" href="javascript:void(0);"> Click here to enter your code.</a>
											</p>
											<div class="order-summary__section order-summary__section--total-lines discount-section" data-order-summary-section="payment-lines" style="display:none;">
												<div>
													<div class="Polaris-Stack Polaris-Stack--vertical" id="plan-options">
														<div class="Polaris-Stack__Item">
															<div><label class="Polaris-Choice" for="disabled"><span class="Polaris-Choice__Control"><span class="Polaris-RadioButton"><input id="disabled" name="accounts" type="radio" class="Polaris-RadioButton__Input" aria-describedby="disabledHelpText" value="basic" checked=""><span class="Polaris-RadioButton__Backdrop"></span></span></span><span class="Polaris-Choice__Label">Basic plan</span></label>
															</div>
														</div>
														<div class="Polaris-Stack__Item">
															<div><label class="Polaris-Choice" for="optional"><span class="Polaris-Choice__Control"><span class="Polaris-RadioButton"><input id="optional" name="accounts" type="radio" class="Polaris-RadioButton__Input" aria-describedby="optionalHelpText" value="tryon"><span class="Polaris-RadioButton__Backdrop"></span></span></span><span class="Polaris-Choice__Label">Tryon plan</span></label>
															</div>
														</div>
													</div>
													<div id="PolarisPortalsContainer"></div>
												</div>
												<form method="post" name="frm_discount" class="frm_discount" action="<?php echo base_url() . "admin/calculate_discount"; ?>">
													<input type="text" name="coupan_code" required placeholder="Discount code">
													<input type="hidden" name="app_total_charge" id="app_total_price" value="<?php echo $app_total_charge; ?>" />
													<input type="hidden" name="shop" value="<?php echo $shop_url; ?>" />
													<input type="button" name="discount" class="discount_apply" value="Apply" />
												</form>
												<div class="alert alert-danger fade in alert-status-container" style="margin-top:18px;">
													<strong>Failed!</strong> <span class="alert-status">Coupon code is invalid</span>
												</div>
												<div class="tag__wrapper" style="display:none;">
													<span class="tags-list"><i class="fa fa-tag" aria-hidden="true"></i><span class="reduction-code__text"></span><i class="fa fa-times close_dis" aria-hidden="true"></i></span>
												</div>
												<div class="calc_discount" style="display:none;">
													<table class="total-line-table">
														<tbody class="total-line-table__tbody">
															<tr class="total-line total-line--subtotal">
																<th class="total-line__name" scope="row">Subtotal</th>
																<td class="total-line__price">
																	<span class="order-summary__emphasis skeleton-while-loading app_total_charge" data-checkout-subtotal-price-target="2999">
																	</span>
																</td>
															</tr>
															<tr class="total-line total-line--subtotal">
																<th class="total-line__name" scope="row">Discount</th>
																<td class="total-line__price">
																	<span class="order-summary__emphasis skeleton-while-loading discount_value" data-checkout-subtotal-price-target="2999">
																	</span>
																</td>
															</tr>
															<tr class="total-line total-line--subtotal">
																<th class="total-line__name" scope="row">You are saving</th>
																<td class="total-line__price">
																	<span class="order-summary__emphasis skeleton-while-loading saving" data-checkout-subtotal-price-target="2999">
																	</span>
																</td>
															</tr>
														</tbody>
														<tfoot class="total-line-table__footer">
															<tr class="total-line">
																<th class="total-line__name payment-due-label" scope="row">
																	<span class="payment-due-label__total">Total</span>
																</th>
																<td class="total-line__price payment-due" data-presentment-currency="USD">
																	<span class="payment-due__currency remove-while-loading"></span>
																	<span class="payment-due__price skeleton-while-loading--lg total_price" data-totalprice="">
																	</span>
																	<span class="totalprice" style="display:none;"></span>
																</td>
															</tr>
														</tfoot>
													</table>
													<p><a href="javascript:void(0);" target="_blank" class="activate_plan">Activate</a></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						<div class="columns">
							<ul class="price">
								<li class="header" style="background-color:#47c1bf">BASIC PLAN</li>
								<li class="grey">$ 295/month</li>
								<li>For TryOn - Additional $50/Month</li>
								<li>The Basic Plan provides access to RingBuilder without the Virtual TryOn feature.</li>
								<?php if ($recurring_charges_data->charge_id == '' &&  $recurring_charges_data->status != 'active') { ?>
									<li class="grey"><a href="<?php echo $charge_api_call . "&price=" . $app_total_bacic . "&plantype=basic"; ?>" target="_top" class="button subscribe-btn">Activate</a></li>
								<?php } else if ($recurring_charges_data->charge_id != '' &&  $recurring_charges_data->status != 'active') { ?>
									<li class="grey"><a href="<?php echo $charge_api_call . "&price=" . $app_total_bacic . "&plantype=basic"; ?>" target="_top" class="button subscribe-btn">Activate</a></li>
								<?php } else if ($recurring_charges_data->charge_id != '' &&  $recurring_charges_data->status == 'active' && $recurring_charges_data->plan == 'Gemfind Basic Plan') { ?>
									<li class="grey" style="color: green;">Active</li>
								<?php } else { ?>
									<li class="grey"><a href="<?php echo $charge_api_call . "&price=" . $app_total_bacic . "&plantype=basic"; ?>" target="_top" class="button subscribe-btn">Downgrade</a></li>
								<?php } ?>
							</ul>
						</div>

						<div class="columns">
							<ul class="price">
								<li class="header" style="background-color:#47c1bf">TRYON PLAN</li>
								<li class="grey">$ 345/month</li>
								<li></li>
								<li>This plan provides access to the RingBuilder with the Virtual TryOn feature.</li>
								<?php if ($recurring_charges_data->charge_id == '' &&  $recurring_charges_data->status != 'active') { ?>
									<li class="grey"><a href="<?php echo $charge_api_call . "&price=" . $app_total_tryon . "&plantype=tryon"; ?>" target="_top" class="button subscribe-btn">Activate</a></li>
								<?php } else if ($recurring_charges_data->charge_id != '' &&  $recurring_charges_data->status != 'active') { ?>
									<li class="grey"><a href="<?php echo $charge_api_call . "&price=" . $app_total_tryon . "&plantype=tryon"; ?>" target="_top" class="button subscribe-btn">Activate</a></li>
								<?php } else if ($recurring_charges_data->charge_id != '' &&  $recurring_charges_data->status == 'active' && $recurring_charges_data->plan == 'Gemfind Tryon Plan') { ?>
									<li class="grey" style="color: green;">Active</li>
								<?php } else { ?>
									<li class="grey"><a href="<?php echo $charge_api_call . "&price=" . $app_total_tryon . "&plantype=tryon"; ?>" target="_top" class="button subscribe-btn">Upgrade</a></li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			<?php } else { ?>
				<span class="heading-customerform">Customer Registration</span>

				<form action="" method="post" name="frmcustomer" class="frmcustomer">
					<div class="form-body">
						<div class="form-group form-horizontal">
							<div class="col-md-6">
								<label for="business">Name of Business<span class="gf-required">*</span></label>
								<input type="hidden" name="shop" value="<?php echo $shop_url; ?>" />
								<input type="text" class="form-control" id="business" name="business" required />
							</div>
							<div class="col-md-6">
								<label for="name">First and Last name of Contact<span class="gf-required">*</span></label>
								<input type="text" class="form-control" id="name" name="name" required />
							</div>
							<div class="col-md-6">
								<label for="email">Email Address<span class="gf-required">*</span></label>
								<input type="text" class="form-control" id="email" name="email" required />
							</div>

							<div class="col-md-6">
								<label for="telephone">Telephone<span class="gf-required">*</span></label>
								<input type="text" class="form-control" id="telephone" name="telephone" required />
							</div>

							<div class="col-md-6">
								<label for="address">Address<span class="gf-required">*</span></label>
								<input type="text" class="form-control" id="address" name="address" required />
							</div>

							<div class="col-md-6">
								<label for="address">City<span class="gf-required">*</span></label>
								<input type="text" class="form-control" id="city" name="city" required />
							</div>

							<div class="col-md-6">
								<label for="address">State<span class="gf-required">*</span></label>
								<input type="text" class="form-control" id="state" name="state" required />
							</div>

							<div class="col-md-6">
								<label for="address">Country<span class="gf-required">*</span></label>
								<input type="text" class="form-control" id="country" name="country" required />
							</div>

							<div class="col-md-6">
								<label for="address">Zip code<span class="gf-required">*</span></label>
								<input type="text" class="form-control" id="zip_code" name="zip_code" required />

								<div class="col-ji-certified">
									<label for="ji-certified">Are you in the Jewelry Industry with a business license?<span class="gf-required">*</span></label>
									<input type="checkbox" class="form-control ji-certified" id="ji-certified" name="ji-certified" value="no" onchange="setCertifiedValue(this)" required />
								</div>

							</div>

							<div class="col-md-6">
								<label for="website_url">Website url</label>
								<input type="text" class="form-control" id="website_url" name="website_url" />
							</div>

							<div class="col-md-6">
								<label for="notes">Notes <span style="font-size: 10px;font-weight:normal;">(Max 1000 Character)<span></label>
								<textarea class="form-control" id="notes" name="notes" maxlength="1000" style="height: 160px; resize: none;"></textarea>
							</div>

							<div class="col-md-6 ">
							</div>

							<div class="form-actions right">
								<input type="submit" name="SubmitCustomerInfo" id="SubmitCustomerInfo" class="btn green" value="Submit">
								<input type="hidden" name="price" id="price" class="btn green" value="<?php echo $recurring_charges_data->price ?>">
								<input type="hidden" name="sp_access_token" value="<?php echo $store_token ?>">
							</div>
						</div>
					</div>
				</form>
				<div class="alert alert-success form-submitmsg">
					<strong>Success!</strong> <span>Thanks for registration. Reloading your the configuration now...</span>
				</div>
			<?php } ?>
		</div>

		<div class="tab-pane" id="smtpconfig" role="tabpanel" aria-labelledby="smtpconfig-tab">
			<form action="" method="post" id="SmtpOption" name="SmtpOption" class="smtpOptions form-horizontal">

				<div class="form-body">
					<div class="form-group">
						<div class="col-md-12">
							<label class="control-label">ENCRYPTION</label>
							<select name="protocol" class="form-control" required>
								<option value="none" <?php if ($protocol == 'none') {
															echo 'selected';
														} ?>>None</option>
								<option value="ssl" <?php if ($protocol == 'ssl') {
														echo 'selected';
													} ?>>SSL</option>
								<option value="tls" <?php if ($protocol == 'tls') {
														echo 'selected';
													} ?>>TLS</option>
							</select>
							<!-- <input type="text" name="protocol" value="<?php echo $protocol; ?>" class="form-control" maxlength="255"  required> -->
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<label class="control-label">STMP HOST</label>
							<input type="hidden" name="shopname" value="<?php echo $diamondconfigdata->shop; ?>" class="form-control" maxlength="255">
							<input type="hidden" name="shopid" value="<?php echo $shopid; ?>" class="form-control" maxlength="255">
							<input type="text" name="smtphost" value="<?php echo $smtphost; ?>" class="form-control" maxlength="255" required>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<label class="control-label">STMP PORT</label>
							<input type="text" name="smtpport" value="<?php echo $smtpport; ?>" class="form-control" maxlength="255" required>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12">
							<label class="control-label">STMP USERNAME</label>
							<input type="text" name="smtpusername" value="<?php echo $smtpusername; ?>" class="form-control" maxlength="255" required>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12">
							<label class="control-label">STMP PASSWORD</label>
							<input type="password" name="smtppassword" value="<?php echo $smtppassword; ?>" class="form-control" maxlength="255" required>
						</div>
					</div>

					<div class="form-group">
						<div class="form-actions right">
							<input type="submit" name="SubmitSmtpSetting" id="SubmitSmtpSetting" class="btn green" value="Submit">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>


</div>
<script type="text/javascript">
	$('.field_hint').mouseover(function() {
		$(".tooltiptext").css("opacity", "1");
		$(".fieldtooltip").css("opacity", "1");
		$(".tooltiptext").css("visibility", "visible");
	});
	$('.field_hint').mouseout(function() {
		$(".tooltiptext").css("opacity", "0");
		$(".tooltiptext").css("visibility", "hidden");
	});
	var spinner = $('#loader');
	$(function() {
		$('#loader').hide();
		$('.frmcustomer').submit(function(e) {
			$('#loader').show();
			e.preventDefault();
			$.ajax({
				url: "<?php echo site_url('Connect/SubmitCustomerInfo'); ?>",
				method: "POST",
				data: $(this).serialize(),
				dataType: 'JSON',
				success: function(data) {
					$('#loader').hide();
					$('.frmcustomer')[0].reset();
					$('.frmcustomer').hide().delay(1000).slideUp();
					$(".form-submitmsg").show().delay(4000).fadeOut();
					setTimeout(function() {
						location.reload(true);
					}, 4000);
					//$(".form-submitmsg").html(data);
				}
			});
		});

		$('.smtpOptions').submit(function(e) {
			$('#loader').show();
			e.preventDefault();
			$.ajax({
				url: "<?php echo site_url('Connect/SubmitCustomerSmtpInfo'); ?>",
				method: "POST",
				data: $(this).serialize(),
				//dataType: 'JSON',
				success: function(response) {
					console.log("coming here");
					$('#loader').hide();
					setTimeout(function() {
						location.reload(true);
					}, 4000);
					//$(".form-submitmsg").html(data);
				}
			});
		});
	});

	function setCertifiedValue(checkbox) {
		if (checkbox.checked) {
			checkbox.value = "Yes";
		} else {
			checkbox.value = "No";
		}
	}

	$(document).ready(function() {
		if ($('#setting-tab').hasClass('active')) {
			$('#pricingplan').removeClass('active');
		}
		$(".button_discount").click(function() {
			$(".discount-section").toggle();
		});
		$(".discount_apply").click(function() {

			if ($("input[type='radio'].Polaris-RadioButton__Input").is(':checked')) {
				var plan_type = $("input[type='radio'].Polaris-RadioButton__Input:checked").val();
				if (plan_type == 'tryon') {
					$('#app_total_price').val(<?php echo APP_TRYON_CHARGE; ?>);
				} else {
					$('#app_total_price').val(<?php echo APP_TOTAL_CHARGE; ?>);
				}
			}
			var form_action = $(".frm_discount").attr("action");
			$.ajax({
				data: $('.frm_discount').serialize(),
				url: form_action,
				type: "POST",
				dataType: 'json',
				success: function(res) {
					console.log(res);
					console.log(res.status);
					if (res.status) {
						var money_format = "<?php echo MONEY_FORMAT; ?>";
						$(".tag__wrapper").show();
						$(".reduction-code__text").html(res.discount_code);
						$(".app_total_charge").html(money_format + res.app_total_charge);
						$(".total_price").html(money_format + res.discounted_total);
						if (res.discount_type == "Percentage") {
							$(".discount_value").html(money_format + res.discount_value);
						} else {
							$(".discount_value").html("-" + money_format + res.discount_value);
						}
						$(".totalprice").html(res.discounted_total);
						$(".saving").html(money_format + res.discount_minus);
						$(".calc_discount").toggle();
						$(".alert-status-container").hide();
						$(".discount_apply").attr('disabled', 'disabled');
						$(".main-activate-link").hide();
					} else {
						$(".tag__wrapper").hide();
						$(".calc_discount").hide();
						$(".alert-status-container").show();
						window.setTimeout(function() {
							$(".alert-status-container").fadeTo(500, 0).slideUp(500, function() {
								$(this).hide();
							});
						}, 4000);
					}
				},
				error: function(data) {}
			});

		});
		$(".activate_plan").click(function() {
			var totalprice = $(".totalprice").html();
			if ($("input[type='radio'].Polaris-RadioButton__Input").is(':checked')) {
				var plan_type = $("input[type='radio'].Polaris-RadioButton__Input:checked").val();
			}
			$(this).attr("href", "<?php echo $charge_api_call . '&price='; ?>" + totalprice + '&plantype=' + plan_type);
			//$(this).click();
			//window.location.href = "<?php echo $charge_api_call . ""; ?>";
		});
		$(".close_dis").click(function() {
			$('.frm_discount')[0].reset();
			$(".tag__wrapper").hide();
			$(".calc_discount").hide();
			$(".discount_apply").removeAttr('disabled');
			$(".main-activate-link").show();
		});
	});
</script>
<div id="loader"></div>
<?php $this->load->view('footer', $footer_data); ?>
<script src="https://unpkg.com/@shopify/app-bridge"></script>
<script>
	var AppBridge = window['app-bridge'];
	var createApp = AppBridge.default;
	var app = createApp({
		apiKey: API_KEY,
		shopOrigin: "<?php echo $_GET['shop']; ?>"
	});
</script>
<script type="text/javascript">
	function showtoptext() {
		var info_html = '<img src="<?php echo base_url(); ?>/assets/images/topAreaText.png">'

		jQuery('#show-filter-info .modal-body p').html(info_html);
		jQuery("#show-filter-info").modal("show");
		jQuery(".test121").css("display", "block");

	}

	function showringtoptext() {
		var info_html = '<img src="<?php echo base_url(); ?>/assets/images/ringDetailAddText.png">'

		jQuery('#show-filter-info .modal-body p').html(info_html);
		jQuery("#show-filter-info").modal("show");
		jQuery(".test121").css("display", "block");
	}

	// function showinfo(){
	// 	var info_html = '<img src="<?php echo base_url(); ?>/assets/images/showinfo.png">'

	// 	jQuery('#show-filter-info .modal-body p').html(info_html);
	//     jQuery("#show-filter-info").modal("show");
	//     jQuery(".test121").css("display", "block");
	// }
</script>
<div class="modal fade" id="show-filter-info" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<p class="note"></p>
			</div>
		</div>
	</div>
</div>