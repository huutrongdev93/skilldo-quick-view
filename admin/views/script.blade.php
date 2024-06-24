<script defer>
    var quickViewStyle = [];

    class QuickViewProductHandler {

	    constructor(element, id) {

		    this.element = element;

		    this.id = id;

		    this.styleId = this.element.find('.js_quick_view_style_item.active').attr('data-style')

		    this.loading = this.element.find('.loading')

		    this.form = this.element.find('.js_quick_view_style_form')

            this.loadForm();
	    }

	    loadForm() {

		    if(this.styleId === undefined) return false;

		    this.loading.show();

		    let self =  this;

		    let data = {
			    action : 'QuickViewAjax::styleLoad',
			    style: this.styleId,
		    }

		    request.post(ajax, data).then(function(response) {

			    self.loading.hide();

			    if(response.status == 'success') {

				    let form = decodeURIComponent(atob(response.data).split('').map(function (c) {
					    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
				    }).join(''));

				    self.form.find('.box-content').html(form).promise().done(function () {
					    FormHelper.reset();
					    FormHelper.validateRegister();
				    });

			    }
			    else {
				    SkilldoMessage.response(response);
			    }
		    });

		    return false;
	    }

	    clickItem(element) {

		    if(element.attr('data-style') == this.styleId) return false;

		    this.element.find('.js_quick_view_style_item').removeClass('active');

		    element.addClass('active');

		    this.styleId = element.attr('data-style');

		    this.loadForm()

		    return false;
	    }

	    save(element) {

		    let data        = element.serializeJSON();

		    data.action     = 'QuickViewAjax::objectSave';

		    data.styleId    = this.styleId;

		    request.post(ajax, data).then(function(response) {

			    SkilldoMessage.response(response);
		    });
	    }
    }

	$(function() {

		quickViewStyle = new QuickViewProductHandler($('.js_quick_view_style_main'), SkilldoUtil.uniqId())

		$(document).on('click', '.js_quick_view_style_item', function() {
			
			return quickViewStyle.clickItem($(this));
		});
	})
</script>
<style>
    <?php include Path::plugin(QV_NAME).'/assets/css/style.css'; ?>
</style>
