{{-- resources/views/components/selects.blade.php --}}

<div id="google_translate_element"></div>

<style>
/* Nascondi "Powered by Google" */
.goog-te-gadget .goog-te-combo {
    margin: 0;
}

.goog-te-gadget {
    font-size: 0 !important;
}

.goog-te-gadget .goog-te-combo {
    font-size: 14px !important;
}

.VIpgJd-ZVi9od-l4eHX-hSRGPd,
.goog-logo-link {
    display: none !important;
}

.goog-te-gadget span {
    display: none !important;
}

.goog-te-gadget > div > div {
    border: none !important;
}
</style>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'it',
    includedLanguages: 'it,en,zh-CN,es'
  }, 'google_translate_element');
}
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>