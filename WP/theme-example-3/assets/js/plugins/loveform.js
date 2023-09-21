import $ from 'jquery';

class LoveForm {
	constructor(){
		$.ready(() => this.initForm());
	}
	initForm() {
		var $et_contact_container = $('.theme_et_pb_contact_form_container');

		if ($et_contact_container.length) {
			$et_contact_container.each(function () {
				var $this_contact_container = $(this),
					$et_contact_form = $this_contact_container.find('form'),
					$et_contact_submit = $this_contact_container.find('input.et_pb_contact_submit'),
					$et_inputs = $et_contact_form.find('input[type=text],textarea'),
					et_email_reg = /^[\w-]+(\.[\w-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)*?\.[a-z]{2,6}|(\d{1,3}\.){3}\d{1,3})(:\d{4})?$/,
					redirect_url = typeof $this_contact_container.data('redirect_url') !== 'undefined' ? $this_contact_container.data('redirect_url') : '';

				/*$et_inputs.live('focus', function () {
					if ($(this).val() === $(this).siblings('label').text()) {
						$(this).val('');
					}
				}).live('blur', function () {
					if ('' === $(this).val()) {
						$(this).val($(this).siblings('label').text());
					}
				});*/

				$et_contact_form.on('submit', function (event) {

					event.preventDefault();


					var $this_contact_form = $(this),
						$this_inputs = $this_contact_form.find('input[type=text]:not(.file-path),input[type=radio],input[type=email],input[type=checkbox],textarea,select,input[type=file]'),
						this_et_contact_error = false,
						$et_contact_message = $this_contact_form.closest('.theme_et_pb_contact_form_container').find('.et-pb-contact-message'),
						et_message = '',
						et_fields_message = '',
						$this_contact_container = $this_contact_form.closest('.theme_et_pb_contact_form_container'),
						$captcha_field = $this_contact_form.find('.et_pb_contact_captcha'),
						form_unique_id = typeof $this_contact_container.data('form_unique_num') !== 'undefined' ? $this_contact_container.data('form_unique_num') : 0,
						inputs_list = [];
					et_message = '<ul>';

					$this_inputs.removeClass('invalid');

					$this_inputs.parent().removeClass('invalid'); // radio and checkboxes
					$this_inputs.parent().parent().removeClass('invalid'); // select

					var verifiedRadios = [];

					$this_inputs.each(function () {
						var $this_el = $(this),
							this_val = $this_el.val(),
							this_label = $this_el.siblings('label').text(),
							field_type = typeof $this_el.data('field_type') !== 'undefined' ? $this_el.data('field_type') : 'text',
							required_mark = typeof $this_el.data('required_mark') !== 'undefined' ? $this_el.data('required_mark') : 'not_required',
							original_id = typeof $this_el.data('original_id') !== 'undefined' ? $this_el.data('original_id') : '',
							default_value;

						// add current field data into array of inputs
						if (typeof $this_el.attr('id') !== 'undefined') {
							inputs_list.push({
								'field_id': $this_el.attr('id'),
								'original_id': original_id,
								'required_mark': required_mark,
								'field_type': field_type,
								'field_label': this_label
							});
						}


						/*
                        'input' => esc_html__( 'Input Field', 'theme' ),
                        'file' => esc_html__('Datei Upload Feld', 'theme'),
                        'email' => esc_html__( 'Email Field', 'theme' ),
                        'number' => esc_html__( 'Number', 'theme'),
                        'date' => esc_html__('Date', 'theme'),
                        'text'  => esc_html__( 'Textarea', 'theme' ),
                        'select' => esc_html__( 'Select', 'theme' ),
                        'checkbox' => esc_html__('Checkboxes', 'theme'),
                        'radiogroup' => esc_html__('Radio Button Group', 'theme'),*/


						// validation

						// check default field types
						if (('input' === field_type || 'date' === field_type || 'text' === field_type || 'number' === field_type || 'email' === field_type) && 'required' === required_mark && ('' === this_val || this_label === this_val)) {
							$this_el.addClass('invalid');
							this_et_contact_error = true;

							default_value = this_label;

							if ('' === default_value && $this_el) {
								default_value = $this_el.attr('id');
							}

							et_fields_message += '<li>' + default_value + '</li>';
						}

						// validate select/dropdowns
						if ('select' === field_type && 'required' === required_mark) {

							var selectedOption = $("option:selected", $this_el);
							// if selected item is not enabled (if selected item is dropdown title)
							if (!selectedOption.is(":enabled")) {

								$this_el.parent().parent().addClass('invalid');
								this_et_contact_error = true;
								// disabled selected option is title
								this_label = selectedOption.text();

								default_value = this_label;

								et_fields_message += '<li>' + default_value + '</li>';
							}
						}

						// validate required radios
						if ('radiogroup' === field_type && 'required' === required_mark) {
							let radioname = $this_el.attr('name');
							if (($.inArray(radioname, verifiedRadios) == -1)) {
								// only validate first radio!
								verifiedRadios.push(radioname);
								let radioelements = $this_el.attr('name');
								let radiolenght = $("input[name='" + radioname + "']:checked").length;
								if (radiolenght == 0) {

									$("input[name='" + radioname + "']").parent().addClass('invalid');

									//$this_el.addClass('invalid');
									this_et_contact_error = true;

									this_label = $this_el.parent().siblings('label').text();

									et_fields_message += '<li>' + this_label + '</li>';
									//et_message += '<li>' + theme_et_pb_custom.invalidradio + '</li>';
								}
							}

						}

						// validate required checkboxes
						if ('checkbox' === field_type && 'required' === required_mark) {
							let radioname = $this_el.attr('name');
							if (($.inArray(radioname, verifiedRadios) == -1)) {
								// only validate first checkbox!
								verifiedRadios.push(radioname);
								let radioelements = $this_el.attr('name');
								let radiolenght = $("input[name='" + radioname + "']:checked").length;
								if (radiolenght == 0) {

									$("input[name='" + radioname + "']").parent().addClass('invalid');

									//$this_el.addClass('invalid');
									this_et_contact_error = true;

									this_label = $this_el.parent().siblings('label').text();
									et_fields_message += '<li>' + this_label + '</li>';
									//et_message += '<li>' + theme_et_pb_custom.invalidcheckbox + '</li>';
								}
							}

						}

						// todo validate file upload!
						if ('file' === field_type && 'required' === required_mark) {
							var ext = $this_el.val().split('.').pop();

							// if file upload is empty
							if (ext === '') {
								$this_el.parent().parent().addClass('invalid');
								this_et_contact_error = true;

								this_label = $this_el.siblings('span').text();
								et_fields_message += '<li>' + this_label + '</li>';
							} else {
								// if file upload has wrong extension
								if (!(ext == "pdf" || ext == "docx" || ext == "jpg" || ext == "zip" || ext == "png" || ext == "doc")) {
									$this_el.parent().parent().addClass('invalid');
									this_et_contact_error = true;

									et_message += '<li>' + theme_et_pb_custom.invalidfile + '</li>';
								}
							}

						}

						// add error message if email field is not empty and fails the email validation
						if ('email' === field_type && '' !== this_val && this_label !== this_val && !et_email_reg.test(this_val)) {
							$this_el.addClass('et_contact_error');
							this_et_contact_error = true;

							if (!et_email_reg.test(this_val)) {
								et_message += '<li>' + theme_et_pb_custom.invalid + '</li>';
							}
						}
					});


					et_message += '</ul>';

					if ('' !== et_fields_message) {
						if (et_message != '<ul></ul>') {
							et_message = '<p class="et_normal_padding">' + theme_et_pb_custom.contact_error_message + '</p>' + et_message;
						}

						et_fields_message = '<ul>' + et_fields_message + '</ul>';

						et_fields_message = '<p>' + theme_et_pb_custom.fill_message + '</p>' + et_fields_message;

						et_message = et_fields_message + et_message;
					}
					$et_contact_message.html(et_message);

					// if no error on form validation
					if (!this_et_contact_error) {
						// disable form container
						$this_contact_container.fadeTo('fast', 0.2);

						var $form = $(this),
							formData = new FormData(),
							params = $form.serializeArray();

						var $href = $(this).attr('action');


						params.push({
							'name': 'et_pb_contact_email_fields_' + form_unique_id,
							'value': JSON.stringify(inputs_list)
						});
						params.push({
							'name': 'form_unique_id',
							'value': form_unique_id
						});
						params.push({
							'name': 'page_id',
							'value': theme_et_pb_custom.page_id
						});
						params.push({
							'name': 'action',
							'value': 'loveform_action'
						});
						params.push({
							'name': 'security',
							'value': theme_et_pb_custom.nonce
						});

						params.push({
							'name': 'title',
							'value': theme_et_pb_custom.title
						});

						params.push({
							'name': 'custom_message',
							'value': theme_et_pb_custom.custom_message
						});

						params.push({
							'name': 'use_redirect',
							'value': theme_et_pb_custom.use_redirect
						});

						params.push({
							'name': 'redirect_url',
							'value': theme_et_pb_custom.redirect_url
						});

						params.push({
							'name': 'success_message',
							'value': theme_et_pb_custom.success_message
						});

						params.push({
							'name': 'email',
							'value': theme_et_pb_custom.email
						});


						params.push({
							'name': 'subject',
							'value': theme_et_pb_custom.subject
						});

						params.push({
							'name': 'submit_txt',
							'value': theme_et_pb_custom.submit_txt
						});

						params.push({
							'name': 'sender_name',
							'value': theme_et_pb_custom.sender_name
						});

						params.push({
							'name': 'sender_mail',
							'value': theme_et_pb_custom.sender_mail
						});

						params.push({
							'name': 'replyto_namefield',
							'value': theme_et_pb_custom.replyto_namefield
						});

						params.push({
							'name': 'replyto_mailfield',
							'value': theme_et_pb_custom.replyto_mailfield
						});


						// push files to form data
						if ($('input[type=file]', $et_contact_form).length !== 0) {
							$.each($('input[type=file]', $et_contact_form), function (index) {
								$.each($('input[type=file]', $et_contact_form)[index].files, function (i, file) {
									var ext = file.name.split('.').pop();
									if (ext == "pdf" || ext == "docx" || ext == "jpg" || ext == "zip" || ext == "png" || ext == "doc") {
										formData.append(file.name, file);
									}
								});
							});
						}

						// Add all params to the formData
						$.each(params, function (i, val) {
							formData.append(val.name, val.value);
						});

						// do ajax call instead of load to submit files
						$.ajax({
							url: theme_et_pb_custom.ajaxurl,
							type: 'POST',
							processData: false,
							contentType: false,
							data: formData,
							success: function (responseText) {
								if (responseText.sent == true) {

									// redirect if redirect URL is not empty and no errors in contact form
									if ('' !== redirect_url) {
										window.location.href = redirect_url;
									} else {
										$et_contact_message.html(et_message);
										$this_contact_container.empty();
										var message = $("<p />").html(theme_et_pb_custom.formsubmit).text();
										$this_contact_container.append(message);


										window.dataLayer = window.dataLayer || [];

										window.dataLayer.push({
											'event': 'rhemeformSubmissionSuccess',
											'formId': 'contactFormTheme'
										});
									}
								} else {
									if (responseText.captcha == true) {
										this.et_pb_maybe_log_event($this_contact_container, 'con_goal');
									} else {
										// captcha fehler!
									}

								}

								$this_contact_container.fadeTo('fast', 1);
							},
							cache: false
						});
					}


					// scroll to top in every case...
					var scrollto = ($this_contact_container.offset().top - 80) + "px";
					if (scrollto < 0) {
						scrollto = 0;
					}
					$("html,body").animate({scrollTop: scrollto}, 500);

					if (et_message != '<ul></ul>') {

						$("html,body").animate({scrollTop: scrollto}, 500);
						// If parent of this contact form uses parallax
						if ($this_contact_container.parents('.et_pb_section_parallax').length) {
							$this_contact_container.parents('.et_pb_section_parallax').each(function () {
								var $parallax_element = $(this),
									$parallax = $parallax_element.children('.et_parallax_bg'),
									is_true_parallax = (!$parallax.hasClass('et_pb_parallax_css'));

								if (is_true_parallax) {
									$et_window.trigger('resize');
								}
							});
						}
					}
				});
			});
		}
	}

	et_pb_maybe_log_event($goal_container, event) {
		var log_event = typeof event === 'undefined' ? 'con_goal' : event;

		if ( ! $goal_container.hasClass( 'et_pb_ab_goal' ) || et_pb_ab_logged_status[ log_event ] ) {
			return;
		}

		// log the event if it's not logged for current user
		this.et_pb_ab_update_stats( log_event );
	}

	et_pb_ab_update_stats(record_type, set_page_id, set_subject_id, set_test_id) {
		var subject_id = typeof set_subject_id === 'undefined' ? this.et_pb_get_subject_id() : set_subject_id,
			page_id = typeof set_page_id === 'undefined' ? theme_et_pb_custom.page_id : set_page_id,
			test_id = typeof set_test_id === 'undefined' ? theme_et_pb_custom.unique_test_id : set_test_id,
			stats_data = JSON.stringify({ 'test_id' : page_id, 'subject_id' : subject_id, 'record_type' : record_type }),
			cookie_subject = 'click_goal' === record_type || 'con_short' === record_type ? '' : subject_id;

		et_pb_set_cookie( 365, 'et_pb_ab_' + record_type + '_' + page_id + test_id + cookie_subject + '=true' );

		et_pb_ab_logged_status[record_type] = true;

		$.ajax({
			type: 'POST',
			url: theme_et_pb_custom.ajaxurl,
			data: {
				action : 'et_pb_update_stats_table',
				stats_data_array : stats_data,
				et_ab_log_nonce : theme_et_pb_custom.et_ab_log_nonce
			}
		});
	}

	et_pb_set_cookie(expire, cookie_content) {
		this.cookie_expire = this.et_pb_set_cookie_expire( expire );
		document.cookie = cookie_content + this.cookie_expire + "; path=/";
	}

	et_pb_set_cookie_expire(days) {
		var ms = days*24*60*60*1000;

		var date = new Date();
		date.setTime( date.getTime() + ms );

		return "; expires=" + date.toUTCString();
	}

	et_pb_get_subject_id() {
		var subject_id_raw = $( '.et_pb_ab_subject' ).attr( 'class' ).split( 'et_pb_ab_subject_id-' )[1],
			subject_id_clean = subject_id_raw.split( ' ' )[0],
			subject_id_separated = subject_id_clean.split( '_' ),
			subject_id = subject_id_separated[1];

		return subject_id;
	}
}

export default new LoveForm();
