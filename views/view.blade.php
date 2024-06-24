<div class="products-detail">
    <div class="row">
        <div class="col-md-7" id="surround">
            @do_action('product_detail_slider', $object)
        </div>
        <div class="col-md-5">
            @do_action('product_detail_info', $object)
        </div>
    </div>
</div>
<script>
	$(function () {
		$('.addtocart_quantity').each(function() {
			let spinner = $(this),
				input = spinner.find('input[type="number"]'),
				btnUp = spinner.find('.quantity-up'),
				btnDown = spinner.find('.quantity-down'),
				min = input.attr('min'),
				max = input.attr('max');

			btnUp.click(function() {
				let oldValue = parseFloat(input.val());
				if (oldValue >= max) {
					var newVal = oldValue;
				} else {
					var newVal = oldValue + 1;
				}
				spinner.find("input").val(newVal);
				spinner.find("input").trigger("change");
			});

			btnDown.click(function() {
				let oldValue = parseFloat(input.val());
				if (oldValue <= min) {
					var newVal = oldValue;
				} else {
					var newVal = oldValue - 1;
				}
				spinner.find("input").val(newVal);
				spinner.find("input").trigger("change");
			});
		});
	})
</script>