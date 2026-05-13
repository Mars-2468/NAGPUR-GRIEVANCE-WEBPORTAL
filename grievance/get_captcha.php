<?php
// We start a session to access
// the captcha externally!
require "config.php";
  
// Generate a random number
// from 1000-9999
$captcha = rand(1000, 9999);
  
// The captcha will be stored
// for the session


// Set the content-type
header('Content-Type: image/png');

$captchaArr = ["Aux9U0","JBXnEQ","1bEI8h","0jrDen","Va4MpO","h9ouIf","IUNFgb","Kn36l4","nuX6jI","hFY7yX","wLN0cv","X7QiQM","gtWcjw","83tGvO","dp5aWx","FWZWnw","oK2Jn1","r1bruA","RB9kUq","GrNXu0","MOFLHX","poSzXM","7eIjgY","6LPsl4","LYUx01","xsfPPT","up6fho","PoYjHn","hsHVqK","hZDhtZ","hTuLli","odJ504","aRB77K","dCUzCz","QmLsT9","o0FIss","cHG5lG","mwbkeY","s7shLj","GvIp7x","CKDnK1","cHgbwH","UHhKmx","zNKnlx","vZiZpH","EHY6JP","Hr6dEy","3sSAxh","8gClJW","iYghrp","Imu0Hc","z7fMjF","R3diHc","a8pwKs","XeyUgl","wbeBne","kc3eHM","6p7I4E","rbH5bC","IIoSJa","CGqeam","BzpaFz","TxEH07","mawagu","8QPTct","AusqsL","FfNgeb","nvTz5Q","Ei2cz8","67bsCN","QVqvEQ","iniiwP","pCAMmV","tcBKV8","wgdF0z","R4OkIS","spjPkl","khhrOu","WvQQcO","GoFIqN","eA57L4","6IN8b5","5xQLMA","1Jyhpv","7AAJXO","geliqp","HsALaE","1HdXtB","SScNaB","xzxASd","LizsBT","u0rw30","JPLytV","65Oxaj","YmvHMk","V5Zy0J","t0HOzw","Pxs3BW","RSwtSD","YVGHQ3","fgha0b","tciqvD","I0AfLB","HmelFS","vtCXcD","ud85jk","ea918Y","O3pW1D","P6NjsL","aK43wV","3G80e9","cNxQfn","3UEYCy","Aja1hH","hDi5t6","L6ufdn","pRCEXi","pBaNo9","nYQ4gm","AntnOZ","wRan5O","KbAVxl","ZJXc80","PwbV7k","y6ezTx","7GTL7a","0E5QfW","KUIn5y","qXdyyV","mclku1","HVL3W9","DDApeP","7NqOwJ","m08A3E","EyPuRC","FGFuXM","Zbxojw","0sptoC","vRTpHl","IhsXc5","JEt6uy","kfE9Wg","FcYEa8","Rdn1lL","ynTDSm","be0BJL","plUBWr","cPKynu","x56BcX","Khbht3","kX8oaS","AX5ijP","zykUC5","BGzgSp","LPe1qk","SOJ9Ko","70MkgF","f8ridM","OnyyJi","h8fjFI","j78y0y","OSgrMI",
"vvBw3n","qOb8Ly","2qPhUW","2lAG9f","QcyaGC","moGLrC","YwER7S","eRPsfc","BT7H8c","xzYx7j","TddsFf","ltkkSk","hqHEVR","gKcSo0","dLQ0IY","8MmWzZ","p9Wa7O","ebocrd","ShZtBS","Khu1rX","HXQpVs","y5z83v","cerigd","INq6LB","1Bfolb","2mmssL","Z3l6yx","KDKEnW","qQMEfZ","lwtFdh","LxhSCh","dVYSpm","PAudJ5","JWgYrs","0EnDGV","KhMYgV","qFm0kh","OiVLXV","fk9H5K","CGIG0Q","x7aPah","1IfZEZ","WrXOaV","e5zG5V","PyYB8k","uSpcZN","sOpE2h","SuuvRw","H0nhps","LfIdNz","fkVixs","kGEMmi","RWlWKk","ckRHiB","D0rgpV","jA4Y95","w3Hg3P","Lkezh3","OnSoDf","4EwSw4","tsTruE","ADIwiq","JSZkhj","jRFJeQ","AZzIhn","LcT0Vd","8bMFak","24HIKz","v32N7v","rPnAMo","oPrlCn","ZZZqQb","vV80AY","4UV3ZA","WZunjq","2A5SOF","TYn3JE","OGWAdR","jjeaIB","K1w7d6","9lW0pm","1Ajuhz","nfJEfv","TiJdfe","HYuI6s","lB1R9k","eqOxj3","klUp94","Hyp7Dr","w5AjzE","Tklelr","5sEPEO","AVlqC7","W7QEOG","NTS5vy","87emMU","nPkUT2","eDdnO7","mZjQgh","AL5Heq","2DJlQM","Ao69Zr","qDOFb3","pbg8sM","bJLsZW","eQHhSw","qlyXCq","h7Pzbt","akwUj1","vT6CnN","ZByhi1","kXPcIb","ZORcOg","j35EbW","yO1DdG","L0Y6Cl","mFwiLF","RHcWaU","03Dp9E","AyTO2P","FiumoY","R3Bhxc","7GzDdu","pGhGdY","tMHoDa","5HOKkb","aEJp18","n22mZd","i1rM17","kaA6hI","bGu1ra","zPVx2B","z8J4sD","jACUhs","7oIpSn","Z5OH07","vvzduq","pDg2HR","YWbXlo","gqgKxs","ehQMwB","2qZdJt","ESajDC","VrVHZb","4NFiNE","e7jFE3","D9WqhT","TfCKTu","AkJ37m","OCzeWu","124XXk","o7SoWl","HUwOmr","msAo4N","fc4JlF","VNp4KT","zuEYuz","TSZESX","re9jX5","tzraC1","vcqUQL","q3Ema2","Ir5wtd",
"q3Zbt3","K63PRw","hNU1M2","cakf69","zumHfr","sjBxBj","fuYrdH","C7443Z","P66qtG","k2Z9Pa","kWTAUf","PrcS7Z","RFfSMS","UvurI7","tJUKb9","Km8cO6","0XwHO4","2PcIko","YHDvUq","zSQxXA","eNCw1N","G8bfSJ","uioWp9","BLKHwJ","s36U00","ZjLOSW","qFCy2x","6QYeeX","qEcMzr","OKkyAc","ZyKh9J","tcRET5","1S37AW","pvzfzQ","z8ruVu","pGRX0R","GBFn8u","x7rghO","wPK19W","ejjPMm","3oy193","jrD3AI","edFNNj","mvVsro","ykxyMo","2qRXIG","0qzaEf","Qbtd5M","hUg84G","bxS82v","bPHAin","pp8r2C","W9dLfk","jZpX2P","Sno8hl","rdfqej","UyI0OC","OLWaZi","ecxzWc","PTKLCa","KWLJjl","hPaVhh","8dS31g","zhpAFo","1I8GlP","RDLMQU","Beiz4L","ywQrA3","OertCI","u9QspT","lWf8Sl","d0N19V","mny6Jr","E8lW5n","NrWaCC","HZe6mq","G4PA8a","337g1O","1vqs63","l31s4C","Bv0mME","LlrHya","LvwNUh","LvLQ8K","qbDbS4","xZV493","Pwj8fN","MSZ1uq","T8Hbch","648Lha","0EknhE","K3U6dt","yk9fqw","21P9qO","milWlx","z77k87","BK9FSi","arxCdS","o5MFlF","9nw7dF","JhKAvM","gtrdkZ","t3t9fY","MTrhLC","WNcjV3","rLmdiz","3AJIR6","eTyrK5","dNqTwS","HxP2fV","K48NIx","nhLOGO","oguUIz","4wGSYK","StmdJh","wcc6h5","0jtMlL","U5cqnG","NgfjAe","4ij65d","2YUetF","kLJUUL","UTeq83","V5gTBD","arCmkZ","IKFC8f","oOMe6S","j0ix4C","HEENDU","EcdDHC","Zl90SN","c12v2u","UVCpsh","CUuCSS","XTZs11","Dc7Qpi","RpkTH1","tDfJgP","bfZkww","3lA12V","vpLl2N","FqcNoE","Hq8av6","5UVxMU","r6nTm4","s2q3J1","QMpCop","DQJicM","FRi5Ms","VG9VEm","FDAHf4","7R9pCg","OFsHyU","EYoQg4","niQYDz","dGyw7x","AayO4u","yTNzy2","pctQX5","6nhi7b","aLecO2","6AYYW0","KukS1O",
"q31891","zy0bF0","OHrXq7","GzYYPU","P4Ozuz","N6rgQo","G0jAe7","jkWhOl","MnHNfk","4kVab4","R2nv9u","t8EWRD","078X7B",'obI5mi','LWhpml','n7IdDw','GcM59j','AMjKv7','rsvGUS','7q2Jhj','7SjjFI','bbCxMH','M4KSzg','080EMv','W8Dmxw','2sUP5n','31DCNM','urSHdS','uxhoAB','AVVm3G','0o81Py','cNM2Bw','Swk6GD','HF0SE2','ifLSZB','uTIY9z','0pVvCI','OacjFl','QLSMMf','W71Q5V','Dqy6zK','AXFZR6','9gLJL8','a5Vsdo','vtrZnZ','yPXOwS','ChKaIa','qnKeLF','y2u0Vq','jJKs2t','XrFP0X','gUC5WM','mLtlH7','pQKZTK','wVPMv3','POUqgB','vnGzLo','I2F4k1','IYkEdJ','LGMoAf','bODEZ9','XgQZVs','p5s4XV','Eag2sj','dsGEJa','2j7xKD','kCpxUG','NrrVq2','Izy3uk','jmwFrJ','TnhotI','UJdmMn','J066fj','GZJ3Cn','qOq4pp','600Ieo','0xYrCL','WpE0Aw','uQuVOL','xMND7t','KdRpCa','ft2NyV','YwSRR6','kNEznT','Y5NMRI','jkEOQx','TfYCLg','q2o6ag','AyFALg','FSC3U5','RO230J','uBjTw8','QLpXLH','9kjtB1','rWCNTd','Z4rZ3Q','QDlAXA','BEhiNH','MMvmSk','72RMjY','qSa8Zd','u6KhOI','sX1Ya1','rWcfsg','FRvhza','xq5BAJ','uqr6pZ','NDZUBQ','cHJ9gN',
'shuUUW','sTJMqq','Oip7s1','PbUSLr','4HUqWd','gOgTDh','7FeSoe','9wxLbE','lTOBMw','AEukzR','7Ij7EJ','oDvw5u','ePMSq5','JpBTbS','DWkpFt','KyZ9wC','jRpmLK','QJ55Ff','co4HOU','5gNqAm','hSGsQf','adMjyV','XfMGww','NgO8va','tvrNHV','AyLrmd','HyaSBg','0XutTX','4agLCE','DyiEKC','hYZecY','bhgVW9','o0PuKK','fJVN4E','q7cU3T','L0JUV5','WH9AXk','U4NC7d','tcydg4','dXZ0JG',
'vPY83A','4FBxFE','4iufTX','EzFD2D','qZgKTA','B2SPUN','dtTgAM','jMI2VU','jabMGe','QvwHKT','yKwws9','eoIE82','hvThUm','y4R3oo','O29CYy','9O44zT','UBLZAA','hRm8mk','gAzGCg','3YDmaC','8uBt79','F5ocis','Fgcuno','xFHpiA','hUGmRW','jGYFvD','j53XXN','m7dw7f','WKlyLH','Ax2TcW','idOheK','16T11I','FRAtye','lbVfnn','XcpE1p','uXuZ4N','jX73OG','TbFLA1','PVdayQ','zSacEc','Ga0Mw6','Zv1m1S','3FFGoV','YeRILd','umj0AD','BwlVmu','DGi6F5','gytL4c','gbnlod','ovafZ1','N6Z0OV','JARqkW','J6XRY5','XycH0W','9o1TtP','I6mNLd','Sj1rVN','fA5Jpi','oHgXAR','5fq3nA','lUwEQ1','zKNbWA','UHuRxN','odC8OY','6mZgH1','QhPCcs','hJDCwW',
'ZBGxWE','GknIon','St9eZk','Wqj9Nc','VNlJ63','ij8OB5','r2wKaK','fo6Paj','rfauCo','vrnXmZ','W2rfiI','A6tlLv','GlZhMa','5UOyk5','GIG7Nn','HUhfNc','iUEi1e','XLGtnD','kSuoo7','Ohax4A','yqdizT','5W6GIM','XnBMWX','tKg6Z8','sFnIgz','PDsyIr','bUuagF','40KLnG','JUkq1n','36OpxV','JKcLFD','f2NnuC','DxY04J','o8pFed','cRttPS','uaVm5Z','X3G3nd','D5hVnf','80ZrEF','gzZetI','qbG7UE','CZaLh5','XAbl5G','TIZ8vJ','StZMby','08WQ2L','3QACSs','HC97Ma','nB4imL','ekPt6Z','qdrjxn','WXFftP','xzIDjq','DC2F3n','bEoXrR','3PlQET','UT4t3P','JqIOSB','eUNarf','iqv3vb','pGHFnS','yj8XyC','aVHbZC','TjiyPN','v0q8oH','hXP2Vt','uqRA6f','VpFEbv','y0azsu','A1LO6M','9AGtAk','vgdwTe','KOJpkH','GfpilS','hGWxm8','UjRJvI','ku1CP8','IRjvOG','Y94wTa','zJwg4n','ZaYelB','Wu9gE5','25hscA','NV3UZB','kTnHyJ','9LH8Fl','Wsib2j','mDa9uO','HVGKP2','tYzUwM','mEr2pi','8JsRHt','ugIgFf','ZZ4lbl','b5ffVT','58hAJo','2VINrq',
'qRdR3Q','j7Aa5o','CysqqD','ZSPzxS','dEwMY6','VG65yR','zUUGuS','7zo7a6','0JPIsr','EJV4bN','DtTPX1','uxowiI','ed65Lu','RMarSD','A23wJA','ojisFA','Dt690H','xZVhuG','dZGQdy','0aAfyN','NwjzSA','T3T8lC','togNWx','rpF5zH','f3IU4v','CLQtff','GJNewE','VUN85i','sAwF18','Fp4fmn','gV95OT','f6L6ea','Tk3cjd','O7bDFZ','u0lI6c','ravHBp','I5mUXl','JBjx72','WWtzuU',
'Cnxl18','Ai6tew','JUW5yd','Ffe7zt','PScTCn','2AnRls','3Y8Nb3','6RwYjV','L9erFA','xjT347','I7ZG05','HrGXK1','1lYLVC','6xoTv5','ZpqHTj','gh8Avu','3oqc5e','o9OlIC','CvuZaQ','YW1uXP','GfsNcG','kfnviK','MhIp96','uiOgVR','TH0FpF','1K8Bkx','u3UI0y','mHkErC','4zNSR6','vszRxJ','9z8u1L','seeHwf','ySVpdE','ZZ0J34','rbvpNP','J216gb','NfMBvp','gKi3xI','P5iRTl','6ut9ac','9fYUQm','pyqTmZ','DFKmhr','6RnBwn','C2hDcH','gBfNLA','UEiEom','dPSnYO','tLqt6K','Lx8WfZ','MdhN7s','u1a23j','X5vyn3','bklHdI','7s8EaP','WsQiUI','B46pyk','hZ2bic','OGgxU8','fogC98','p3YgDh','prXCJr','T6fBEL','GeEGpE','AODaFK','R9h4cf','KIlJcY',
'kCcaa3','IgtWgw','KIwg4M','8Hwhum','X7iIt0','yXLhVQ','b9VJIV','xnCbLD','v4D6el','ZFTG0d','mxeLeV','J7F6hX','ttZmQ1','dnvPIe','HFOW4P','Uwb43D','fleLxU','rMR8zh','618d1V','AlAOdb','AcwHnK','gr6OrS','Vm7Mqx','VefVlQ','9JsJRl','cVU03w','zWA8oS','fwPHUr','TvxXQI','lsrYpt','aELoEh','i8n6dC','fsoWXl','Ezp1u5','JfL8g0','tQBERC','BB5T0D','hEYjvF','w0KgYb','ErkJoB','rYR2gU','NcNhWR','phdscv','LrIThj','srWzwv','gZrfXD','Mie4fE','Y92x8u','lyB5XK','IVofLZ','N8wpOY','FrjJJd','E38CXs','Y69ilW','SUsSw0','jSykLE','wUEWMS','A6dnVY','AHtVLr','ooV0bW','BhWc7O','7EUhfL','T3DsfH','vnRTRA','DcBtIp','bFlpIY','DRoon4','PaUfYp','nbDvPR','F3JBz6','oxE7DC','XrOHFh','htDj5u','bciqMo','oB0W9y','HmPpzi','AaxlUV','FrviIX','8Eujqc','bxLOq8','pFRejZ','lWpnUO','OCmRii','JkxqmE','5jbn0X','E0bde4','xUxS7c','1spiGJ','KCu7ys','LqoqVV','QOtGyS','y8YmF4','otMKB8','o93cUu','4PrGVP'];

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

// $captchaTxt = generateRandomString();
$captchaTxt = (isset($_GET['rand']) )? $_GET['rand'] : 50;
$_SESSION["captcha"] = $captchaArr[$captchaTxt]; 

$ImageText1Small = imagecreate( 148, 16 );
$ImageText1Large = imagecreate( 148, 16 );
$ImageText2Small = imagecreate( 308, 40 );
$ImageText2Large = imagecreate( 308, 40 );
$ImageFinal = imagecreate( 180, 80 );

$backgroundColor1 = imagecolorallocate($ImageText1Small, 255,255,255);
$textColor1 = imagecolorallocate($ImageText1Small, 0,0,0);

$backgroundColor2 = imagecolorallocate($ImageText2Small, 255,255,255);
$textColor2 = imagecolorallocate($ImageText2Small, 0,0,0);

imagestring( $ImageText1Small, 1, 1, 0,  $captchaArr[$captchaTxt],  $textColor1 );
imagestring( $ImageText2Small, 5, 1, 0,  $captchaArr[$captchaTxt],  $textColor2 );

imagecopyresampled($ImageText1Large, $ImageText1Small, 0, 0, 0, 0, 148, 16, 74, 8);
imagecopyresampled($ImageText2Large, $ImageText2Small, 0, 0, 0, 0, 308, 40, 154, 20);

$ImageText1Large = imagerotate ( $ImageText1Large, 20, $backgroundColor1 );
$ImageText2Large = imagerotate ( $ImageText2Large, -5, $backgroundColor2 );

$ImageText1W = imagesx($ImageText1Large);
$ImageText1H = imagesy($ImageText1Large);

$ImageText2W = imagesx($ImageText2Large);
$ImageText2H = imagesy($ImageText2Large);

imagecopymerge($ImageFinal, $ImageText1Large, 350, 20, 0, 0, $ImageText1W, $ImageText1H, 100);
imagecopymerge($ImageFinal, $ImageText2Large, 20, 20, 0, 0, $ImageText2W, $ImageText2H, 100);

header( "Content-type: image/png" );
imagepng($ImageFinal);

imagecolordeallocate( $ImageText1, $textColor1 );
imagecolordeallocate( $ImageText2, $textColor2 );
imagedestroy($ImageText1); 
imagedestroy($ImageText2); 
?>