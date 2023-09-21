<template>
    <form v-if="i18n.locale !== 'fr_FR'" class="layout_form cr_form cr_font" action="https://eu2.cleverreach.com/f/221946-215406/wcs/"
          method="post" target="_blank">
        <div class="cr_body cr_page cr_font formbox">
            <div class="non_sortable" style="text-align:left;"></div>

            <div class="editable_content" style="text-align:left;">
                <div id="4615118" rel="checkbox" class="cr_ipe_item ui-sortable musthave" style=" margin-bottom:0px;">
                    <span class="itemname">Entscheiden Sie, welche Mitteilungen Sie erhalten.*</span>
                    <br/><br/>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input id="Newsletter4615118" class="custom-control-input" name="1061310[]" value="Newsletter" type="checkbox"/>
                            <label class="custom-control-label" for="Newsletter4615118">Newsletter</label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input id="E-News4615118" class="custom-control-input" name="1061310[]" value="E-News" type="checkbox"/>
                            <label class="custom-control-label" for="E-News4615118">E-News</label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input id="Medieninfos4615118" class="custom-control-input" name="1061310[]" value="Medieninfos"
                                   type="checkbox"/>
                            <label class="custom-control-label" for="Medieninfos4615118">Medieninfos</label>
                        </div>
                        <br>
                    </div>
                </div>
                <div id="4615308" rel="mce_text" class="cr_ipe_item ui-sortable">
                    <div class="mce_text"><p>Newsletter: Vierteljährliche und vertiefte Informationen von TA-SWISS<br> E-News: Aktuelles zu
                        Ausschreibungen, Publikationen und Veranstaltungen<br> Medieninfos: Mitteilungen und Einladungen für
                        Medienschaffende<br></p></div>
                </div>

                <div id="4615139" rel="mce_text" class="cr_ipe_item ui-sortable">
                    <div class="mce_text"><p>* Pflichtfelder<br><br></p></div>
                </div>

                <div id="4615135" rel="email" class="cr_ipe_item ui-sortable musthave" style="margin-bottom:0;">
                    <label for="text4615135" class="itemname">E-Mail*</label> <input class="form-control" id="text4615135" name="email"
                                                                                     value="" type="text"
                                                                                     style="width:100%;"/>
                </div>
                <div id="4615137" rel="recaptcha" class="cr_ipe_item ui-sortable musthave">
                    <br/>
                    <div id="recaptcha_v2_widget" class="g-recaptcha" data-theme="light" data-size="normal"
                         data-sitekey="6Lfhcd0SAAAAAOBEHmAVEHJeRnrH8T7wPvvNzEPD"></div>
                    <br/>

                </div>
                <div id="4615138" rel="button" class="cr_ipe_item ui-sortable submit_container"
                     style="text-align:center; margin-bottom:0;">
                    <button type="submit" class="btn btn-primary float-right">Anmelden</button>
                </div>
            </div>
        </div>
    </form>
    <form v-else class="layout_form cr_form cr_font" action="https://eu2.cleverreach.com/f/221946-215408/wcs/" method="post"
          target="_blank">
        <div class="cr_body cr_page cr_font formbox">
            <div class="non_sortable" style="text-align:left;"></div>

            <div class="editable_content" style="text-align:left;">
                <div id="4615162" rel="checkbox" class="cr_ipe_item ui-sortable musthave" style=" margin-bottom:0px;">
                    <span class="itemname">Choisissez les communications que vous recevez.*</span><br><br>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input id="Newsletter4615162" class="custom-control-input" name="1061310[]" value="Newsletter"
                                   type="checkbox"/>
                            <label class="custom-control-label" for="Newsletter4615162">Newsletter</label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input id="E-News4615162" class="custom-control-input" name="1061310[]" value="E-News" type="checkbox"/>
                            <label class="custom-control-label" for="E-News4615162">E-News</label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input id="Medieninfos4615162" class="custom-control-input" name="1061310[]" value="Medieninfos"
                                   type="checkbox"/>
                            <label class="custom-control-label" for="Medieninfos4615162">Infos médias</label>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <div id="4618474" rel="mce_text" class="cr_ipe_item ui-sortable">
                <div class="mce_text">
                    <div style="overflow: auto;" mce_style="overflow: auto;">Newsletter : Informations trimestrielles et approfondies de
                        TA-SWISS<br>E-News : Nouvelles sur les appels d'offres, publications et événements<br>Infos médias :
                        Communications
                        et invitations pour les professionnels des médias<br></div>
                </div>
            </div>
            <br/><br/>
            <div id="4615236" rel="email" class="cr_ipe_item ui-sortable musthave form-group" style="margin-bottom:px;">
                <label for="text4615236" class="itemname">E-mail*</label> <input id="text4615236" class="form-control" name="email" value=""
                                                                                 type="text"
                                                                                 style="width:100%;"/>
            </div>
            <div id="4615180" rel="recaptcha" class="cr_ipe_item ui-sortable musthave">
                <br/>
                <div id="recaptcha_v2_widget" class="g-recaptcha" data-theme="light" data-size="normal"
                     data-sitekey="6Lfhcd0SAAAAAOBEHmAVEHJeRnrH8T7wPvvNzEPD"></div>
                <br/>
            </div>
            <div id="4615238" rel="button" class="cr_ipe_item ui-sortable submit_container"
                 style="text-align:center; margin-bottom:15px;">
                <button type="submit" class="btn btn-primary float-right">Inscription</button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        data: () => ({
            initialized: false,
            old_src: null
        }),
        mounted() {
            const targetNode = this.$el.closest('.modal');
            const observer = new MutationObserver(() => {
                if (targetNode.style.display !== 'none' && !this.initialized) {
                    this.initialized = true;
                    this.loadRecaptcha();

                    this.$nextTick(() => {
                        this.main();
                    });
                }
            });

            observer.observe(targetNode, {attributes: true, childList: true});
        },
        methods: {
            loadRecaptcha() {
                /**
                 * script src="https://www.google.com/recaptcha/api.js" async defer..
                 */
                const script = document.createElement('script');
                script.setAttribute('src', 'https://www.google.com/recaptcha/api.js');
                document.getElementsByTagName('head')[0].appendChild(script);
            },
            captcha_reload() {
                const $cr = jQuery.noConflict();
                const timestamp = new Date().getTime();
                $cr('div[rel=\'captcha\'] img:not(.captcha2_reload)').attr('src', '');
                $cr('div[rel=\'captcha\'] img:not(.captcha2_reload)').attr('src', this.old_src + '?t=' + timestamp);
                return false;
            },
            main() {
                const $cr = jQuery.noConflict();

                $cr(document).ready(function () {
                    $cr('.cr_form').submit(function () {
                        $cr(this).find('.clever_form_error').removeClass('clever_form_error');
                        $cr(this).find('.clever_form_note').remove();
                        $cr(this).find('.musthave').find('input, textarea').each(function () {
                            if (jQuery.trim($cr(this).val()) == '' || ($cr(this).is(':checkbox')) || ($cr(this).is(':radio'))) {
                                if ($cr(this).is(':checkbox') || ($cr(this).is(':radio'))) {
                                    if (!$cr(this).closest('.musthave').find(':checked').is(':checked')) {
                                        $cr(this).parent().addClass('clever_form_error');
                                    }
                                } else {
                                    $cr(this).addClass('clever_form_error');
                                }
                            }
                        });
                        if ($cr(this).attr('action').search(document.domain) > 0 && $cr('.cr_form').attr('action').search('wcs') > 0) {
                            const cr_email = $cr(this).find('input[name=email]');
                            const unsub = false;
                            if ($cr('input[\'name=cr_subunsubscribe\'][value=\'false\']').length) {
                                if ($cr('input[\'name=cr_subunsubscribe\'][value=\'false\']').is(':checked')) {
                                    unsub = true;
                                }
                            }
                            if (cr_email.val() && !unsub) {
                                $cr.ajax({
                                    type: 'GET',
                                    url: $cr('.cr_form').attr('action').replace('wcs', 'check_email') + $cr(this).find('input[name=email]').val(),
                                    success: function (data) {
                                        if (data) {
                                            cr_email.addClass('clever_form_error').before('<div class=\'clever_form_note cr_font\'>' + data + '</div>');
                                            return false;
                                        }
                                    },
                                    async: false
                                });
                            }
                            const cr_captcha = $cr(this).find('input[name=captcha]');
                            if (cr_captcha.val()) {
                                $cr.ajax({
                                    type: 'GET',
                                    url: $cr('.cr_form').attr('action').replace('wcs', 'check_captcha') + $cr(this).find('input[name=captcha]').val(),
                                    success: function (data) {
                                        if (data) {
                                            cr_captcha.addClass('clever_form_error').after('<div style=\'display:block\' class=\'clever_form_note cr_font\'>' + data + '</div>');
                                            return false;
                                        }
                                    },
                                    async: false
                                });
                            }
                        }
                        if ($cr(this).find('.clever_form_error').length) {
                            return false;
                        }
                        return true;
                    });
                    $cr('input[class*="cr_number"]').change(function () {
                        if (isNaN($cr(this).val())) {
                            $cr(this).val(1);
                        }
                        if ($cr(this).attr('min')) {
                            if (($cr(this).val() * 1) < ($cr(this).attr('min') * 1)) {
                                $cr(this).val($cr(this).attr('min'));
                            }
                        }
                        if ($cr(this).attr('max')) {
                            if (($cr(this).val() * 1) > ($cr(this).attr('max') * 1)) {
                                $cr(this).val($cr(this).attr('max'));
                            }
                        }
                    });
                    this.old_src = $cr('div[rel=\'captcha\'] img:not(.captcha2_reload)').attr('src');
                    if ($cr('div[rel=\'captcha\'] img:not(.captcha2_reload)').length != 0) {
                        this.captcha_reload();
                    }
                });
            }
        }
    };

</script>

<style lang="scss">
    //.cr_site {
    //    margin: 0;
    //    padding: 75px 0 0 0;
    //    text-align: center;
    //    background-color: #eeeeee;
    //}
    //
    //.cr_font {
    //    font-size: 14px;
    //}
    //
    //.cr_body h2, .cr_header h2 {
    //    font-size: 22px;
    //    line-height: 28px;
    //    margin: 0 0 10px 0;
    //}
    //
    //.cr_body h1, .cr_header h2 {
    //    font-size: 28px;
    //    margin-bottom: 15px;
    //    padding: 0;
    //    margin-top: 0;
    //}
    //
    //.wrapper, .cr_page {
    //    margin: 0 auto 10px auto;
    //    text-align: left;
    //    border-radius: 4px;
    //}
    //
    //.cr_header {
    //    text-align: center;
    //    background: transparent !important;
    //}
    //
    //.cr_body label {
    //    float: none;
    //    clear: both;
    //    display: block;
    //    width: auto;
    //    margin-top: 8px;
    //    text-align: left;
    //    font-weight: bold;
    //    position: relative;
    //}
    //
    //.cr_button {
    //    display: inline-block;
    //    width: auto;
    //    white-space: nowrap;
    //    height: 32px;
    //    margin: 5px 5px 0 0;
    //    padding: 0 22px;
    //    text-decoration: none;
    //    text-align: center;
    //    font-weight: bold;
    //    font-style: normal;
    //    font-size: 15px;
    //    line-height: 32px;
    //    cursor: pointer;
    //    border: 0;
    //    -moz-border-radius: 4px;
    //    border-radius: 4px;
    //    -webkit-border-radius: 4px;
    //    vertical-align: top;
    //}
    //
    //.cr_button {
    //    background-color: #333;
    //    color: #ffffff;
    //}
    //
    //.cr_button:hover, .cr_button-small:hover {
    //    opacity: 0.7;
    //    filter: alpha(opacity=70);
    //}
    //
    //.powered {
    //    padding: 20px 0;
    //    width: 560px;
    //    margin: 0 auto;
    //}
    //
    //.cr_ipe_item label {
    //    line-height: 150%;
    //    font-size: 14px;
    //}
    //
    //.cr_ipe_item textarea {
    //    background: none repeat scroll 0 0 #eeeeee;
    //    border: 1px solid #aaa;
    //    font-size: 16px;
    //}
    //
    //.cr_ipe_item input {
    //    background: none repeat scroll 0 0 #eeeeee;
    //    border: 1px solid #aaa;
    //    padding: 5px;
    //    font-size: 16px;
    //}
    //
    //.cr_ipe_item select {
    //    background: none repeat scroll 0 0 #eeeeee;
    //    border: 1px solid #aaa;
    //    display: block;
    //    margin: 0;
    //    padding: 5px;
    //    width: 100%;
    //    font-size: 16px;
    //}
    //
    //.cr_ipe_item input.cr_ipe_radio, input.cr_ipe_checkbox {
    //    -moz-binding: none;
    //    -moz-box-sizing: border-box;
    //    background-color: -moz-field !important;
    //    border: 2px inset threedface !important;
    //    color: -moz-fieldtext !important;
    //    cursor: default;
    //    height: 13px;
    //    padding: 0 !important;
    //    width: 13px;
    //}
    //
    //.cr_ipe_item input.cr_ipe_radio {
    //    -moz-appearance: radio;
    //    border-radius: 100% 100% 100% 100% !important;
    //    margin: 3px 3px 0 5px;
    //}
    //
    //.submit_container {
    //    text-align: center
    //}
    //
    //.cr_ipe_item {
    //    padding: 1px 10px;
    //    margin: 1px 10px;
    //}
    //
    //.cr_ipe_item.inactive {
    //    display: none;
    //}
    //
    //.imprint {
    //    font-size: 0.8em;
    //}
    //
    //.cr_captcha {
    //    padding-left: 130px;
    //}
    //
    .cr_error {
        font-size: 1.1em;
        padding: 10px;
    }
    //
    .clever_form_error {
        background-color: #f99;
        color: #000;
        border: 1px solid #f22 !important;
        margin-bottom: 5px;
    }
    //
    //.clever_form_note {
    //    margin: 26px 0 0 3px;
    //    position: absolute;
    //    display: inline;
    //    padding: 2px 4px;
    //    font-weight: bold;
    //    background-color: #f2ecb5;
    //    color: #000;
    //    font-size: 12px !important;
    //}
    //
    //.cr_site {
    //    background-color: #eee;
    //}
    //
    //.cr_header {
    //    color: #000000;
    //}
    //
    //.cr_body {
    //}
    //
    //.cr_hr {
    //    background-color: #ccc;
    //}
    //
    //.cr_site a {
    //    color: #0084ff;
    //}
    //
    //.imprint {
    //    color: #000;
    //}
</style>
