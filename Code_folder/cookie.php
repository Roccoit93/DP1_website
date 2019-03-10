<script type='text/javascript'> //navigator contiene info sul browser
    if(navigator.cookieEnabled==false) //cookieEnabled ritorna un booleano per dire se i cookie sono abilitati o no
    {
      document.write('Enable cookies on your browser to continue.');
        window.stop();// stoppa il caricamento della finestra
        alert ('Cookies disabled!');
    }
</script>

<noscript class="noscript">
<div id="jsMsg" >
  Warning: Javascript disabled!Please enable it to use the application web pages!</div>
</noscript>
