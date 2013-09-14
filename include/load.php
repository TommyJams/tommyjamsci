<style type='text/css'>
div#content {
    display: none;
    }
 
div#loading {             
    top: 200 px;
    margin: auto;
    position: absolute;
    z-index: 1000;
    width: 160px;
    height: 24px;
    background: url(images/progressbar.gif) no-repeat;
    cursor: wait;                
    }
</style>

<script type="text/javascript">
        function preloader(){
            document.getElementById("loading").style.display = "none";
            document.getElementById("content").style.display = "block";
        }//preloader
        window.onload = preloader;
</script>
