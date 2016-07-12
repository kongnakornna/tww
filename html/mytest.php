<!DOCTYPE html>
<html>
<body>
<?php
$note=<<<XML
<data><status>ok</status>
<responsecode>MPIGA0000</responsecode>
<detail>Success</detail>
<incCustFee>0.00</incCustFee>
<tranId>1111291163</tranId>
<tranAmt1>214.00</tranAmt1>
<piList><?xml version="1.0" encoding="UTF-8"?>
<java version="1.5.0_11" class="java.beans.XMLDecoder">
 <array class="com.ais.mpay.payment.bean.MerCustPiBean" length="1">
  <void index="0">
   <object class="com.ais.mpay.payment.bean.MerCustPiBean">
    <void property="bankCode">
     <string>999</string>
    </void>
    <void property="brandId">
     <int>50002</int>
    </void>
    <void property="currentBal">
     <double>8922779.13</double>
    </void>
    <void property="customerId">
     <long>200000000001921</long>
    </void>
    <void property="defaultPi">
     <string></string>
    </void>
    <void property="ivrCode">
     <string>9999999</string>
    </void>
    <void property="piDesc">
     <string>mCASH</string>
    </void>
    <void property="piId">
     <int>1</int>
    </void>
    <void property="piStatus">
     <string></string>
    </void>
    <void property="seqNum">
     <int>1</int>
    </void>
    <void property="status">
     <string>Active</string>
    </void>
   </object>
  </void>
 </array>
</java>
</piList>
<totalAmt>214.00</totalAmt>
<sessionId>20160214518685</sessionId>
<productAmt>214.00</productAmt>
</data>
XML;

$xml=simplexml_load_string(str_replace('<?xml version="1.0" encoding="UTF-8"?>','',$note));
print_r($xml);
?>
</body>
</html>
