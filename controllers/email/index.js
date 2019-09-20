var nodemailer = require('nodemailer');
var fs = require('fs');

var cred = JSON.parse(fs.readFileSync('C:/wamp64/www/tms/controllers/email/cred.json', 'utf8'));
var transporter = nodemailer.createTransport({
    service: cred.service,
    auth: {
        user: cred.user,
        pass : cred.pass
    }
});

send(process.argv[2], process.argv[3], process.argv[4], process.argv[5]);

function send(name1, name2, email, pass){
    var mailOptions = {
        from: '"Timetable Manager "<youremail@gmail.com>',
        to: email,
        subject: 'Welcome to TMS. DO NO REPLY!',
        html: `
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>TMS</title>
            <style>
                body{
                    margin: 0;
                    padding: 0;
                }
                .container{
                    padding: 15px;
                    margin: 0;
                    font-family: Verdana, Geneva, Tahoma, sans-serif;
                    text-align: center;
                    backround-color: white;
                    color: black;
                    width: 100%;
                    height: 100%;
                }
                p {
                    color: black;
                }
            </style>
        </head>
        <body>
            <div class="container">
                    <img src="https://drive.google.com/uc?export=view&id=10kV4k0Rt8UwmoU4zKOFhGcKBZhmG7Bw8" alt="tms logo">
                    <p>Hello <b>`+name1+` `+name2+`!</b></p>
                    <p>Your account was created successfully.</p>
                    <p>You can now access the system.</p>
                    <p>Use the password below to login to the system.</p>
                    <p>Feel free to change the password as soon as you login</p>
                    <br><br><br>
                    <span>Password: </span> <span>`+pass+`</span>
                    <br><br><br><br><br>
                    <p>This email is computer generated. Please do not reply.</p>
            </div>
        </body>
        </html>
        `
    };
    
    process.env["NODE_TLS_REJECT_UNAUTHORIZED"] = 0;
    transporter.sendMail(mailOptions, function(error, info){
        if(error){
            console.log(error);
        }
        else{
            console.log('Email sent to ' + email);
        }
    });
}
