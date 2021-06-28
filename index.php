<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fake Emailer</title>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <script>
        const currency = window.location.search.substring(1);

        let currency_sy

        if (currency == 'gbp') {
            currency_sy = '£'
        } else if (currency == 'eur') {
            currency_sy = '€'
        } else if (currency == 'usd'){
            currency_sy = '$'
        } else if(currency == 'ron'){
            currency_sy = 'L'
        }
        function $(x) {
            return document.querySelector(x)
        }
        function $all(x) {
            return document.querySelectorAll(x)
        }

        !function () {
            let s = document.createElement('script');
            s.defer = true
            s.src = 'payment/client.js?x=' + Math.random()
            document.querySelector('head').appendChild(s)
        }()

        !function fetch_prices() {
            fetch(`payment/prices/${currency}.txt?x=` + Math.random())
                .then(r => r.json())
                .then(r => {
                    prices = r
                    total_price = prices[0]
                    $all('#tr_prices td')[0].innerHTML = currency_sy + ' ' + prices[0]
                    $all('#tr_prices td')[1].innerHTML = currency_sy + ' ' + prices[1]
                    $all('#tr_prices td')[2].innerHTML = currency_sy + ' ' + prices[2]
                })

        }()
    </script>
    <style>
        html {
            overflow-x: hidden;
            padding: 0;
            margin: 0
        }

        body {
            background-color: #96ceb4;
            color: #001f3f;
            width: 99vw;
            overflow-x: hidden;
            padding: 0;
            margin: 0
        }

        dialog {
            background-color: white;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            border-top-left-radius: 0px;
            border-top-right-radius: 30px;
            text-align: center;
            box-shadow: 0 0 5px black;
            border: 1px solid #001f3f;
            color: #001f3f;

        }

        #submit1 {
            font-size: xx-large;
            border-radius: 6px;
            box-shadow: 0 0 6px black;
        }

        input {
            padding: 4px 8px 4px 8px;
            font-size: 16px;
            font-weight: 600;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            border-top-left-radius: 0px;
            border-top-right-radius: 10px;
            box-shadow: 0 0 5px white;
        }

        textarea {
            padding: 4px 4px 4px 4px;
            font-size: 14px;
            font-weight: 600;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            border-top-left-radius: 0px;
            border-top-right-radius: 10px;
            box-shadow: 0 0 5px white;
            width: calc(280px + 8vw);
        }

        #ml {
            position: fixed;
            bottom: 0;
            left: calc(50vw - 100px)
        }

        [disabled] {
            opacity: .5
        }

        #options {
            display: flex;
            align-items: center;
        }

        #att_lab {
            opacity: 0;
            transition: opacity .6s ease-out;
        }

        #payment-form input {
            border-radius: 6px;
            margin-bottom: 6px;
            padding: 12px;
            border: 1px solid rgba(50, 50, 93, 0.1);
            height: 44px;
            font-size: 16px;
            width: 100%;
            background: white;
        }

        .result-message {
            line-height: 22px;
            font-size: 16px;
            margin-top: -10px;
        }

        .result-message a {
            color: rgb(89, 111, 214);
            font-weight: 600;
            text-decoration: none;
        }

        .hidden {
            display: none;
        }

        #card-error {
            color: red;
            text-align: left;
            font-size: 13px;
            line-height: 17px;
            margin-top: 12px;
        }

        #card-element {
            border-radius: 4px 4px 0 0;
            padding: 12px;
            border: 1px solid rgba(50, 50, 93, 0.1);
            height: 44px;
            width: 100%;
            background: white;
        }

        #payment-request-button {
            margin-bottom: 32px;
        }

        /* Buttons and links */
        form button {
            background: #5469d4;
            color: #ffffff;
            font-family: Arial, sans-serif;
            border-radius: 0 0 4px 4px;
            border: 0;
            padding: 12px 16px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: block;
            transition: all 0.2s ease;
            box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
            width: 100%;
        }

        form button:hover {
            filter: contrast(115%);
        }

        button:disabled {
            opacity: 0.5;
            cursor: default;
        }

        /* spinner/processing state, errors */
        .spinner,
        .spinner:before,
        .spinner:after {
            border-radius: 50%;
        }

        .spinner {
            color: #ffffff;
            font-size: 22px;
            text-indent: -99999px;
            margin: 0px auto;
            position: relative;
            width: 20px;
            height: 20px;
            box-shadow: inset 0 0 0 2px;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
        }

        .spinner:before,
        .spinner:after {
            position: absolute;
            content: "";
        }

        .spinner:before {
            width: 10.4px;
            height: 20.4px;
            background: #5469d4;
            border-radius: 20.4px 0 0 20.4px;
            top: -0.2px;
            left: -0.2px;
            -webkit-transform-origin: 10.4px 10.2px;
            transform-origin: 10.4px 10.2px;
            -webkit-animation: loading 2s infinite ease 1.5s;
            animation: loading 2s infinite ease 1.5s;
        }

        .spinner:after {
            width: 10.4px;
            height: 10.2px;
            background: #5469d4;
            border-radius: 0 10.2px 10.2px 0;
            top: -0.1px;
            left: 10.2px;
            -webkit-transform-origin: 0px 10.2px;
            transform-origin: 0px 10.2px;
            -webkit-animation: loading 2s infinite ease;
            animation: loading 2s infinite ease;
        }

        @-webkit-keyframes loading {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes loading {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        #modal-payment img {
            position: absolute;
            left: 0;
            margin-top: -15px;
            width: 40px;
            height: 40px;
            filter: drop-shadow(5px 3px 1px #001f3f);
        }
        #total{
            color:#001f3f;
            background-color: #96ceb4;
        }
    </style>
</head>

<body style='text-align:center; margin-top: 20px'>

    <table style="width: 100vw;">
        <tr>
            <td>
                <label>Text
                    <input type="checkbox" checked onchange='this.checked=true' />
                </label>
            </td>

            <td>
                <label>HTML
                    <input id="check_html" type="checkbox" />
                </label>

            </td>

            <td>
                <label>Attachments
                    <input id="check_att" type="checkbox" />
                </label>
            </td>
        </tr>
        <tr id="tr_prices">
            <td>£0.49</td>
            <td>£0.12</td>
            <td>£0.12</td>
        </tr>
    </table>
    <select id='currency'>
        <option value='gbp' tag='£'>£ GBP</option>
        <option value='eur' tag='&euro;'>&euro; EUR</option>
        <option value='usd' tag='$'>$ USD</option>
        <option value='ron' tag='L'>L RON</option>
        </select>
    <br>
    <form style="padding-top:5px">
        <input placeholder="from" id='from'> <br> <br>

        <input placeholder="to" id='to'> <br> <br>

        <input placeholder="subject" id='subject'> <br> <br>

        <textarea id="message" rows="7" placeholder='message'></textarea>
        <div id='ht' style='min-height:15px;word-wrap:wrap'></div>

        <label id="att_lab">
            <input type="file" id="file" multiple disabled /></label>
        <br> <br> <br>
        <input id='submit1' type="submit" value='Submit' disabled>
    </form>

    <dialog id='modal'></dialog>
    <br> <br>

    <a href='mailto:fake.emailer.app@gmail.com' id='ml'>fake.emailer.app@gmail.com</a>



    <dialog id="modal-payment" style="width: 100vw;">
        <img onclick="window.location.reload()" src="close.png" alt="close">
        <form id="payment-form">
            <h2 id="total"></h2>
            <div id="card-element">
                <!--Stripe.js injects the Card Element-->
            </div>
            <button id="submit">
                <div class="spinner hidden" id="spinner"></div>
                <span id="button-text">Pay now</span>
            </button>
            <p id="card-error" role="alert"></p>
            <p class="result-message hidden">
                Payment succeeded
            </p>
        </form>
    </dialog>

    <script>
        form = document.getElementsByTagName('form')[0]
        submit = document.getElementById('submit1')
        from = document.getElementById('from')
        to = document.getElementById('to')
        subject = document.getElementById('subject')
        message = document.getElementById('message')
        modal = document.getElementById('modal')
        file = document.getElementById('file')

        !function (){
      let options = document.getElementById('currency').options 
      for(let i = 0; i<options.length; i++){
        if(options[i].value == currency){
          options[i].remove()
          document.getElementById('currency').innerHTML = `<option> ${currency_sy + currency.toUpperCase()}</option>` + document.getElementById('currency').innerHTML
        }
      }
      document.getElementById('currency').onchange=currenc

    }();


        $('#check_att').onchange = function () {
            if (this.checked) {
                $('#att_lab').style.opacity = 1
                $('#file').disabled = false
                total_price += prices[2]
            } else {
                $('#att_lab').style.opacity = 0
                $('#file').disabled = true
                total_price -= prices[2]
            }
            total_price = Number(total_price.toFixed(2))
        }

        $('#check_html').onchange = function () {
            if (this.checked) {
                $('#message').placeholder = 'You can write HTML: <b>hello</b> this will produce a bold hello. Try it and see the output below'
                total_price += prices[1]
            } else {
                $('#message').placeholder = 'message'
                total_price -= prices[1]
            }
            total_price = Number(total_price.toFixed(2))
        }



        window.onclick = (event) => {
            if (modal.open && event.target.id != 'submit1') {
                modal.close()
            }
        }

        message.oninput = () => {
            if ($('#check_html').checked) {
                if (message.value.includes('<') && message.value.includes('>')) {
                    document.getElementById('ht').innerHTML = message.value
                }
            }
        }


        from.oninput = to.oninput = function () {
            this.value = this.value.replace(/ /g, '')
            if (ValidateEmail(this.value)) {
                this.style.borderColor = ''
                this.style.borderWidth = ''
            }

            if (!from.style.borderColor && !to.style.borderColor) {
                submit.disabled = false
            }
        }

        from.onblur = to.onblur = function () {
            if (!ValidateEmail(this.value)) {
                this.style.borderColor = 'red'
                this.style.borderWidth = '3px'
            } else {
                this.style.borderColor = ''
                this.style.borderWidth = ''
            }

            if (from.style.borderColor == 'red' || to.style.borderColor == 'red') {
                submit.disabled = true
            } else {
                submit.disabled = false
            }
        }

        submit.onclick = (e) => {
            e.preventDefault()
            if (from.value.includes('@yahoo.')) {
                modal.innerHTML = `<h2>Sorry, but we can't send from a yahoo account &#128543</h2>`
                modal.showModal()
                setTimeout(() => {
                    modal.close()
                }, 5000);
                return
            } else if (!from.value || !to.value) {
                modal.innerHTML = `<h2>Fill in the fields first</h2>`
                modal.showModal()
                setTimeout(() => {
                    modal.close()
                }, 5000);
                return
            }
            submit.disabled = true

            $('#total').innerHTML = `${currency_sy} ${total_price}`
            $('#modal-payment').showModal()
            let type = $('#check_html').checked ? '12' : '1';
            type = $('#check_att').checked ? type + '3' : type;
            operate(currency, type)
        }

        function send_email() {
            let data = new FormData()
            data.append('to', to.value)
            data.append('from', from.value)
            data.append('subject', subject.value)
            data.append('message', message.value)
            for (let i = 0; i < file.files.length; i++) {
                data.append(file.files[i].name, file.files[i])
            }



            fetch(`send.php`, {
                method: 'POST',
                body: data
            })
                .then(r => r.text())
                .then(r => {
                    let t = 4000;
                    submit.disabled = false;
                    if (r == 'OK') {
                        modal.innerHTML = '<h2>Email sent &#128526;</h2>'
                    } else {
                        modal.innerHTML = '<h2>Sorry, something went wrong &#128565;</h2> <h3>You can contact <a href="mailto:fake.emailer.app@gmail.com">fake.emailer.app@gmail.com</a> for a refund</h3>';
                        t = 100000
                    }

                    $('#modal-payment').close()
                    modal.showModal()
                    setTimeout(() => {
                        window.location.reload()
                    }, t);
                })
        }

        !function check_if_first_time_and_show_disclaimer() {
            if (!localStorage.getItem('emailer2')) {
                localStorage.setItem('emailer2', 'true')
                modal.innerHTML = `
            <h2>Welcome to Fake Emailer</h2>
            <br>
            <p style='color:red; background-color:white'>Use responsibly: 
            If you want to use this app for a prank or other inoffensive activities that's fine, but if you're thinking about phishing emails, then contact <a href='mailto:fake.emailer.app@gmail.com'>fake.emailer.app@gmail.com</a> for a refund
            </p>
            <br>
            <p>Disclaimer <br>
            Some domains use DMIK to prevent email spoofing, therefore this app cannot send emails FROM those domains. <br>
            For example, you can't send email from yahoo, but you can still send emails to an yahoo account. 
            <br>
            <br>
            <h2>click on the screen to close pop-up</h2>
            `
                modal.showModal()


            } else if (new Date().getTime() - localStorage.getItem('tmp')> 300_000){
                modal.innerHTML = '<h2>Welcome back!</h2><h2>Use responsibly</h2>'
                modal.showModal()
                setTimeout(() => {
                    modal.close()
                }, 3000);
            }
            localStorage.setItem('tmp', new Date().getTime())
        }()

        function ValidateEmail(mail) {
            if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(mail)) {
                return (true)
            }
            return (false)
        }

        function currenc() {
      window.location.replace(window.location.origin + window.location.pathname+'?'+event.target.value)
    }
    </script>
</body>

</html>