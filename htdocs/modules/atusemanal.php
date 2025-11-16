<?PHP

function updaterank() {
   global $db;
     $updrank = $db->Execute("SELECT Id, TotalScore FROM game ORDER BY 'TotalScore' DESC");
     $rank = 0;
     foreach ($updrank->GetArray() as $r => $rankinfo) {
          $rank++;
          $db->Execute("UPDATE game SET TotalRank=? WHERE Id = ?", array($rank,$rankinfo['Id']));
     }
}

function updategrade() {
   global $db;


					
	            $db->Execute("UPDATE game SET CountryGrade='-4' WHERE TotalGrade='-4' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='-3' WHERE TotalGrade='-3' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='-2' WHERE TotalGrade='-2' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='-1' WHERE TotalGrade='-1' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='0' WHERE TotalGrade='0' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='1' WHERE TotalGrade='1' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='2' WHERE TotalGrade='2' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='3' WHERE TotalGrade='3' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='4' WHERE TotalGrade='4' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='5' WHERE TotalGrade='5' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='6' WHERE TotalGrade='6' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='7' WHERE TotalGrade='7' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='8' WHERE TotalGrade='8' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='9' WHERE TotalGrade='9' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='10' WHERE TotalGrade='10' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='11' WHERE TotalGrade='11' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='12' WHERE TotalGrade='12' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='13' WHERE TotalGrade='13' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='14' WHERE TotalGrade='14' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='15' WHERE TotalGrade='15' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='16' WHERE TotalGrade='16' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='17' WHERE TotalGrade='17' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='18' WHERE TotalGrade='18' and  NoRankUpdate = 0");
             
                    $db->Execute("UPDATE game SET CountryGrade='19' WHERE TotalGrade='19' and  NoRankUpdate = 0");
      
                    
                    
      
}
function updateguilds() {
	global $config, $db;

	$result = $db->Execute("SELECT DISTINCT Guild, count( Id ) as counts, sum(TotalScore) as TotalScores
						FROM game
						WHERE Guild IS NULL
						OR Guild != ''
						GROUP BY Guild order by TotalScores desc");
	if ($db->Affected_Rows() > 0) {
	
		foreach ($result->GetArray() as $rs => $r) {
		
			$db->Execute('Update game set MemberCount = ? where Guild = ?', array($r['counts'], $r['Guild']));
			$result2 = $db->Execute("Select Id, Guild from game where Guild=? order by TotalScore desc",array($r['Guild']));
			if ($db->Affected_Rows() > 0) {
				$grank=0;
				foreach ($result2->GetArray() as $rs2 => $r) {
				$grank++;
					$db->Execute('Update game set GuildRank = ? where Guild = ? and Id=?', array($grank, $r['Guild'],$r['Id']));
					
				}
			}
		}
	
	}

}


updaterank();
updategrade();
updateguilds();
header('Refresh: 1; url=atu3.jsp');
?>
<link href="template/www.johan.com.br/images/portal.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound_content.css" rel="stylesheet" type="text/css" />
<link href="css/gunbound_main.css" rel="stylesheet" type="text/css" />

<script language="javascript">
<!--
  function SexChange()
  {
     url ="avatarlist.html?IT=all&amp;page=&amp;SCH=&amp;ODR=6&amp;SX=";
     url = url + document.Frm1.SX.options[document.Frm1.SX.selectedIndex].value;
     location.href = url
  }
//-->
</script>
<script language="JavaScript">
<!--
function bluring(){
if(event.srcElement.tagName=="A"||event.srcElement.tagName=="IMG") 
	document.body.focus();
}
document.onfocusin=bluring;
// -->
</script>

<script type="text/JavaScript">
<!--



function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<style type="text/css">
<!--
.parte1 {
	font-family: "Trebuchet MS";
	font-weight: bold;
	font-size: 36px;
	color: #999900;
}
.parte2 {
	font-size: 16px;
	color: #333333;
}
.aguardeservices {color: #666666}
-->
</style>
<body>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  </tr>
</table>
<table width="706" border="0">
  <tr>
    <td width="584" align="center"><img src="template/www.johan.com.br/images/pranking.jpg" width="581" height="15"><br>
      <table width="560" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#F9F9F9">
        <tr>
          <td width="12" valign="top"></td>
                <td width="545" align="center" valign="top"><p class="parte1"><span class="parte2">[1]</span> <span class="parte1">[2] </span> <span class="parte2">[3]</span></p>
                <p><strong>Atualizando Servidores! (Script By GBrasil)</strong><br>
                  <span class="aguardeservices">Aguarde por-favor. </span></p></td>
        </tr>
      </table>
    <p>&nbsp;</p></td><td width="1"></td>
    <td width="71"><br />
      <br />
      <br />
    <br />    </td>
    <td width="23">&nbsp;</td>
  </tr>
</table>
