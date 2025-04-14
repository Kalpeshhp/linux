<!DOCTYPE html>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Custom Tailors</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Roboto', sans-serif;">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="padding:0 10px;">
    <tr>
      <td>
        <table style="border-bottom: 1px solid #bebebe;padding: 20px 0;" cellpadding="0" cellspacing="0" width="100%" >
          <tr>
            <td style="width:50%;">
              <img src="{{asset('/images/logo-email.png')}}" alt="Custom Tailors" style="width:200px;">
            </td>
            <td  align="right" style="width:50%;vertical-align: top;">
              <a href="" style="color: #808080;text-decoration: none;">login to customtailorsstore.com</a>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    {{-- <tr>
      <td>
        <h2 style="font-size: 35px;font-weight: 100;line-height: 1.3;">Verify your e-mail to finish <br>signing up for Tailor I Online Platform</h2>
      </td>
    </tr> --}}
    <tr>
      <td>
        <table  style="border-bottom: 1px solid #bebebe;padding-bottom: 10px;margin-bottom: 20px;" cellpadding="0" cellspacing="0" width="100%" >
          <tr>
            <td>
              <h3 style="margin-top: 0;font-size: 23px;font-weight: 400;">Hey {{$data['name']}},</h3>
              <p style="color: #808080;">Thanks for registering an account with <span style="color:#000000">CustomTailorsStore</span>
              </p>
              <p style="color: #808080;">Please login your account by clicking on the button</p>
              <p style="color: #808080;"><b>Username:</b>{{$data['email']}}</p>
              @if(array_key_exists('password',$data))
                <p style="color: #808080;"><b>Password:</b>password</p>
              @endif

              <a href="{{env('APP_URL')}}" style="width: 100%; background: #3d3f92;color: #fff;float: left;text-align: center; padding: 15px; border-radius: 5px;font-size: 21px;margin: 30px 0;">Login</a>
            </td>
          </tr>
        </table>
        
      </td>
    </tr>
    <tr align="center">
      <td>
        <p style="color: #808080;line-height: 1.4;font-size: 14px;">Need help? Ask at <a href="mailto:support@textronic.net" style="color: #3d3f92;">support@textronic.net</a> or Visit our <a href="" style="color: #3d3f92;">Support Center</a></p>
        <img align="center" src="{{asset('/images/logo-2.png')}}" alt="Textronic" style="width:120px; margin: 10px 0;">
        <p style="color: #808080;line-height: 1.4;font-size: 14px;">
          Plot. No. EL-109, 2nd Floor,<br>
          TTC Electronics Zone, MIDC Mahape,<br>
          Navi Mumbai 400 710, INDIA
        </p>
      </td>
    </tr>
    
  </table>
</body>
</html>