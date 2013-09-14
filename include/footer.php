<!--<div id="mainfooter" class="mainfooter">
    <div class="sociallinks">
        <a href="http://twitter.com/" target="_blank" class="social" id="twitter" title="twitter"></a>
        <a href="http://www.facebook.com/akashgroup" target="_blank" id="facebook" class="social"></a>
    
        <a href="#" class="option" >About</a>
        <a href="#" class="option" >Artists</a>
        <a href="#" class="option" >T&C</a>
        <a href="#" class="option" >Privacy</a>
        <a href="#" class="option" >FAQ</a>
        <a  href="javascript:;" onClick="loadblog('blog');" class="option" >Blog</a>
    </div>
</div>-->

<script type="text/javascript">

/*Example message arrays for the two demo scrollers*/

<? 
include("connect.php");
$pname="";
$SQLs = "SELECT * FROM `$database`.`members` WHERE type='Promoter' ORDER BY id DESC LIMIT 5";
$results = mysql_query($SQLs);
while ($a = mysql_fetch_assoc($results))
{$pname=$pname . "," . $a["name"] . " ";}
$aname="";
$SQLs = "SELECT * FROM `$database`.`members` WHERE type='Artist' ORDER BY id DESC LIMIT 5";
$results = mysql_query($SQLs);
while ($a = mysql_fetch_assoc($results))
{$aname=$aname . "," . $a["name"] . " ";}
$gig="";
$SQLs = "SELECT * FROM `$database`.`shop` ORDER BY id DESC LIMIT 2";
$results = mysql_query($SQLs);
while ($a = mysql_fetch_assoc($results))
{$gig=$gig.", ".$a["gig"]."(Launched by- $a[promoter_name])" ." ";;
}
$dib="";
$SQLs = "SELECT * FROM `$database`.`transaction` ORDER BY id DESC LIMIT 2";
$results = mysql_query($SQLs);
while ($a = mysql_fetch_assoc($results))
{$dib=$dib.", ". $a["artist_name"]. " DIBBED ". $a["gig_name"]. " Launched by " .$pro=$a["promoter_name"] . "  ";}
?>
var pausecontent2=new Array()
pausecontent2[0]='<a href="javascript:;" onClick=toggle("footer_below");><font style="color:#2B92FA; font-family:Droid Sans,Arial,sans-serif;"><b>&nbsp;&nbsp;<? print("$pname Joined us as Promoter Recently");?></b></font>&nbsp;&nbsp;</a>'
pausecontent2[1]='<a href="javascript:;" onClick=toggle("footer_below");><font style="color:#2B92FA; font-family:Droid Sans,Arial,sans-serif;"><b>&nbsp;&nbsp;<? print("$aname Joined us as Artist Recently");?></b></font>&nbsp;&nbsp;</a>'
pausecontent2[2]='<a href="javascript:;" onClick=toggle("footer_below");><font style="color:#2B92FA; font-family:Droid Sans,Arial,sans-serif;"><b>&nbsp;&nbsp;<? print("$gig Launched Recently");?></b></font>&nbsp;&nbsp;</a>'
pausecontent2[3]='<a href="javascript:;" onClick=toggle("footer_below");><font style="color:#2B92FA; font-family:Droid Sans,Arial,sans-serif;"><b>&nbsp;&nbsp;<? print("$dib");?></b></font>&nbsp;&nbsp;</a>'



</script>

<script type="text/javascript">

function pausescroller(content, divId, divClass, delay){
this.content=content //message array content
this.tickerid=divId //ID of ticker div to display information
this.delay=delay //Delay between msg change, in miliseconds.
this.mouseoverBol=0 //Boolean to indicate whether mouse is currently over scroller (and pause it if it is)
this.hiddendivpointer=1 //index of message array for hidden div
document.write('<div id="'+divId+'" class="'+divClass+'" style="position: relative; overflow: hidden"><div class="innerDiv" style="position: absolute; width: 100%" id="'+divId+'1">'+content[0]+'</div><div class="innerDiv" style="position: absolute; width: 100%; visibility: hidden" id="'+divId+'2">'+content[1]+'</div></div>')
var scrollerinstance=this
if (window.addEventListener) //run onload in DOM2 browsers
window.addEventListener("load", function(){scrollerinstance.initialize()}, false)
else if (window.attachEvent) //run onload in IE5.5+
window.attachEvent("onload", function(){scrollerinstance.initialize()})
else if (document.getElementById) //if legacy DOM browsers, just start scroller after 0.5 sec
setTimeout(function(){scrollerinstance.initialize()}, 500)
}


pausescroller.prototype.initialize=function(){
this.tickerdiv=document.getElementById(this.tickerid)
this.visiblediv=document.getElementById(this.tickerid+"1")
this.hiddendiv=document.getElementById(this.tickerid+"2")
this.visibledivtop=parseInt(pausescroller.getCSSpadding(this.tickerdiv))
//set width of inner DIVs to outer DIV's width minus padding (padding assumed to be top padding x 2)
this.visiblediv.style.width=this.hiddendiv.style.width=this.tickerdiv.offsetWidth-(this.visibledivtop*2)+"px"
this.getinline(this.visiblediv, this.hiddendiv)
this.hiddendiv.style.visibility="visible"
var scrollerinstance=this
document.getElementById(this.tickerid).onmouseover=function(){scrollerinstance.mouseoverBol=1}
document.getElementById(this.tickerid).onmouseout=function(){scrollerinstance.mouseoverBol=0}
if (window.attachEvent) //Clean up loose references in IE
window.attachEvent("onunload", function(){scrollerinstance.tickerdiv.onmouseover=scrollerinstance.tickerdiv.onmouseout=null})
setTimeout(function(){scrollerinstance.animateup()}, this.delay)
}




pausescroller.prototype.animateup=function(){
var scrollerinstance=this
if (parseInt(this.hiddendiv.style.top)>(this.visibledivtop+5)){
this.visiblediv.style.top=parseInt(this.visiblediv.style.top)-5+"px"
this.hiddendiv.style.top=parseInt(this.hiddendiv.style.top)-5+"px"
setTimeout(function(){scrollerinstance.animateup()}, 50)
}
else{
this.getinline(this.hiddendiv, this.visiblediv)
this.swapdivs()
setTimeout(function(){scrollerinstance.setmessage()}, this.delay)
}
}



pausescroller.prototype.swapdivs=function(){
var tempcontainer=this.visiblediv
this.visiblediv=this.hiddendiv
this.hiddendiv=tempcontainer
}

pausescroller.prototype.getinline=function(div1, div2){
div1.style.top=this.visibledivtop+"px"
div2.style.top=Math.max(div1.parentNode.offsetHeight, div1.offsetHeight)+"px"
}



pausescroller.prototype.setmessage=function(){
var scrollerinstance=this
if (this.mouseoverBol==1) //if mouse is currently over scoller, do nothing (pause it)
setTimeout(function(){scrollerinstance.setmessage()}, 100)
else{
var i=this.hiddendivpointer
var ceiling=this.content.length
this.hiddendivpointer=(i+1>ceiling-1)? 0 : i+1
this.hiddendiv.innerHTML=this.content[this.hiddendivpointer]
this.animateup()
}
}

pausescroller.getCSSpadding=function(tickerobj){ //get CSS padding value, if any
if (tickerobj.currentStyle)
return tickerobj.currentStyle["paddingTop"]
else if (window.getComputedStyle) //if DOM2
return window.getComputedStyle(tickerobj, "").getPropertyValue("padding-top")
else
return 0
}

</script>
<!--<div id="footer">-->
    <!--<div class="horizontalSep">-->
    <table id = "footerTable">
        <tr>            <!-- This is the update/news scroller we are commenting.
            <td width="10%"><a href="#" style="font-family:'Droid Sans','Arial','sans-serif'; color:#FF0000; text-decoration:none;"><b>UPDATES:</b></a></td>
            <td width="5%"></td>
            <td width="85%">                            <script type="text/javascript">
                    //new pausescroller(name_of_message_array, CSS_ID, CSS_classname, pause_in_miliseconds)
                    new pausescroller(pausecontent2, "pscroller2", "someclass", 3000)
                </script>                            </td>            -->            <?            if( true )            {            print("            <td>                <a  href="javascript:;" onClick="loadframe('gigs');">                    <img style="height:60px; margin-right:20px;"                         src="images/icons/footer_mic.png"                         onmouseover="this.src = 'images/icons/footer_mic_yellow.png';"                         onmouseout="this.src = 'images/icons/footer_mic.png';"                         alt="My Gigs"                         title="My Gigs"                    /> <!--My Gigs-->                </a>            </td>            <td>                <a  href="javascript:;" onClick="loadframe('add');">                    <img style="height:60px; margin-right:20px;"                         src="images/icons/footer_add.png"                         onmouseover="this.src = 'images/icons/footer_add_yellow.png';"                         onmouseout="this.src = 'images/icons/footer_add.png';"                         alt="Launch Gig"                         title="Launch Gig"                    /> <!--Launch-->                </a>            </td>            <td>                <a href="javascript:;" onClick="loadframe('left');">                    <img style="height:60px; margin-right:20px;"                         src="images/icons/footer_user.png"                         onmouseover="this.src = 'images/icons/footer_user_yellow.png';"                         onmouseout="this.src = 'images/icons/footer_user.png';"                         alt="Profile"                         title="Profile"                    /> <!--Profile-->                </a>            </td>            <td>                <div class="menu" id="signupmenu">                    <a href="fbconnect.php?what=1">                        <div style="height:25px; font-size:0px; width:90px;  cursor:pointer; background:url(images/fbpro.png) no-repeat;" onClick="fbstuff('Promoter')">                        Promoter                        </div>                    </a>                </div>            </td>                <td>                <div class="menu" id="signupmenu">                    <a href="fbconnect.php?what=2">                        <div style="height:25px;  font-size:0px; width:70px; cursor:pointer; background:url(images/fbart.png) no-repeat;" onClick="fbstuff('Artist')">                        Artist                        </div>                    </a>                </div>            </td>            <td>                <a href="logout.php">Log Out</a>            </td>            <td>                                            <!--<div id="arrow">-->                    <a  href="javascript:;" onClick="toggle('footer_below');" >                        <img src="images/expand.png">                    </a>                <!--</div>-->            </td>            ");            ?>
        </tr>
    </table>
    <!--</div> horizontalSep-->
<!--</div> footer-->

<div id="footer_below" style=" display:none; ">
    <div id="downarrow">            <a  href="javascript:;" onClick="toggle('footer_below');" >                    <img src="images/contract.png">        </a>        </div>
<table cellspacing="55" cellpadding="15" width="90%"><tr><td width="10%">New members---</td><? 

$SQLs = "SELECT * FROM `$database`.`members` ORDER BY id DESC LIMIT 2";
$results = mysql_query($SQLs);
while ($a = mysql_fetch_assoc($results))
{$name=$a["name"];$type=$a["type"];
print("<td width=45%>&nbsp;&nbsp;&nbsp; <b><u>$name</u></b> joined us as a $type<br></td>");
}
?>
</tr><tr><td width="10%">New GIG----</td>
<?
$SQLs = "SELECT * FROM `$database`.`shop` ORDER BY id DESC LIMIT 2";
$results = mysql_query($SQLs);
while ($a = mysql_fetch_assoc($results))
{$gig=$a["gig"];$pro=$a["promoter_name"];
print("<td>&nbsp;&nbsp;&nbsp; <b><u>$gig</u></b> GIG launched by <b><u>$pro</u></b><br></td>");
}
?> </tr><tr><td width="10%">New DIB----</td> <?
$SQLs = "SELECT * FROM `$database`.`transaction` ORDER BY id DESC LIMIT 2";
$results = mysql_query($SQLs);
while ($a = mysql_fetch_assoc($results))
{$gig=$a["gig_name"];$pro=$a["promoter_name"];$artist=$a["artist_name"];
print("<td>&nbsp;&nbsp;&nbsp; <b><u>$artist</u></b> DIBed <b><u>$gig</u></b> launched by <b><u>$pro</u></b><br></td>");
}
?> </tr><tr><td width="10%">Handshake---</td> <?

$SQLs = "SELECT * FROM `$database`.`transaction` WHERE status=1 ORDER BY id DESC LIMIT 2";
$results = mysql_query($SQLs);
while ($a = mysql_fetch_assoc($results))
{$gig=$a["gig_name"];$pro=$a["promoter_name"];$artist=$a["artist_name"];
print("<td>&nbsp;&nbsp;&nbsp; <b><u>$gig</u></b> is Booked to <b><u>$artist</u></b> by <b><u>$pro</u></b><br></td>");
}?>
</tr></table>



</div>