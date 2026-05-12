function validateForm()
        { 
            var p = new Array();
             p['a'] = "1df8";
             p['b'] = "9jfr";
             p['c'] = "8rlB";
             p['d'] = "UlPT";
             p['e'] = "MpFe";
             p['f'] = "Ui18";
             p['g'] = "WrM3";
             p['h'] = "N1JL";
             p['i'] = "6RIy";
             p['j'] = "fzkd";
             p['k'] = "QniU";
             p['l'] = "p1JP";
             p['m'] = "vKzW";
             p['n'] = "7fwK";
             p['o'] = "tfxt";
             p['p'] = "kODR";
             p['q'] = "2Du6";
             p['r'] = "tTlj";
             p['s'] = "8r5N";
             p['t'] = "GyiK";
             p['u'] = "XQbC";
             p['v'] = "yySm";
             p['w'] = "5Adl";
             p['x'] = "wTvg";
             p['y'] = "MocI";
             p['z'] = "Ey0U";
             p['A'] = "P6gE";
             p['B'] = "f0vQ";
             p['C'] = "CCQ5";
             p['D'] = "448z";
             p['E'] = "dbQN";
             p['F'] = "IugC";
             p['G'] = "RClE";
             p['H'] = "3HF5";
             p['I'] = "2UlP";
             p['J'] = "PxYV";
             p['K'] = "6JpV";
             p['L'] = "F9Xf";
             p['M'] = "A1T6";
             p['N'] = "t10l";
             p['O'] = "aizD";
             p['P'] = "1T43";
             p['Q'] = "4uRh";
             p['R'] = "LuYr";
             p['S'] = "oO35";
             p['T'] = "Rj5w";
             p['U'] = "l6cg";
             p['V'] = "N512";
             p['W'] = "htoG";
             p['X'] = "YreT";
             p['Y'] = "RH71";
             p['Z'] = "D9Es";
             p['0'] = "s886";
             p['1'] = "hnjJ";
             p['2'] = "em8X";
             p['3'] = "v0hA";
             p['4'] = "xVZ4";
             p['5'] = "1eoo";
             p['6'] = "Drt7";
             p['7'] = "51ZX";
             p['8'] = "U6e0";
             p['9'] = "tVWf";
             p['!'] = "VzoA";
             p['@'] = "tO3B";
             p['#'] = "ulGb";
             p['$'] = "JAmW";
             p['%'] = "cUmA";
             p['^'] = "gOyf";
             p['&'] = "vzFy";
             p['*'] = "IFFu";
             p['?'] = "gO5a";
         
            var old_password=$("#old_password").val();
            var pwd=$("#password").val();
            var con_pwd = $("#password2").val();
            var ciper = '';
            var ciper2 = '';
            var con_ciper = '';
            var con_ciper2 = '';
            var old_ciper = '';
            var old_ciper2 = '';
            for(var i=0;i<pwd.length;i++){
                 ciper = ciper+p[pwd[i]];
            }
            for(var j=0;j<ciper.length;j++){
                ciper2 = ciper2+p[ciper[j]];
            }
            
            for(var i=0;i<con_pwd.length;i++){
                 con_ciper = con_ciper+p[con_pwd[i]];
            }
            for(var j=0;j<con_ciper.length;j++){
                con_ciper2 = con_ciper2+p[con_ciper[j]];
            }
            
            for(var i=0;i<old_password.length;i++){
                 old_ciper = old_ciper+p[old_password[i]];
            }
              
            for(var j=0;j<old_ciper.length;j++){
                old_ciper2 = old_ciper2+p[old_ciper[j]];
            }
         
            $('#password').val(ciper2);
            $('#old_password').val(old_ciper2);
            $('#password2').val(con_ciper2);
            return true;
        }
        
    $(document).ready(function() {
    $('#butundisab').click(function(event){
    
        data = $('.password').val();
        
        //alert(data);
        
        var len = data.length;
        
        //alert(len); 
        
        if(len < 1) {
            
           // alert("Password cannot be blank");
            // Prevent form submission
            
            event.preventDefault();
        }
        if($('.password').val() == $('.old_password').val()) {
            //alert("Password and Confirm Password don't match");
            $('#disp1').show();
            // Prevent form submission
            event.preventDefault();
        }
         
        if($('.password').val() != $('.password_again').val()) {
            //alert("Password and Confirm Password don't match");
            $('#disp').show();
            // Prevent form submission
            event.preventDefault();
        }
         
    });
});