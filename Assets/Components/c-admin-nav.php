<?php if (current_user_can('administrator')) { ?>
	<div class="adminNav" id="adminNav">
		<div class="adminNav__item">
			<input type="checkbox" id="hideAdminBar">
			<label for="hideAdminBar">Hide Admin Bar</label>
		</div>

		<span class="adminNav__close" id="adminNavClose">×</span>

		<div class="adminNav__item">
			<input type="checkbox" id="hideHeader">
			<label for="hideHeader">Hide Header</label>
		</div>

		<?php if (is_front_page()) { ?>
			<div class="adminNav__item">
				<input type="checkbox" id="fillForm">
				<label for="fillForm">Fill Form</label>
			</div>
		<?php } ?>
	</div>

	<script>
		$('#adminNavClose').click(function() {
			$('#adminNav').fadeOut()
		})

		$('#hideAdminBar').change(function() {
			$('#wpadminbar').slideToggle()
		})
		$('#hideHeader').change(function() {
			$('header').slideToggle()
		})

		$('#fillForm').change(function() {
			//= text ====
			$('input#text').val('テキストが入ります');

			//= select box ====
			$('select#age option:last').prop('selected', true);
			$('select#chocolate option:last').prop('selected', true);

			//= checkbox radio ====
			$('input#confirm-1').prop('checked', true);
			$('input#gender-1').prop('checked', true);
		})
	</script>
<?php } ?>
