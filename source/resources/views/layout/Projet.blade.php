<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AnnotateME</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/interfaces.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/form.css') }}">

        <!-- Styles -->
        <style>
           
 




            

        </style>

        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function() 
            {
                var body = document.querySelector("body");
                var a = document.querySelector("a");
                var onoffswitch = document.querySelector(".onoffswitch");
                var myonoffswitch = document.querySelector("#myonoffswitch");
                var buttonList = document.getElementsByClassName("buttonList");
                var input = document.getElementsByClassName("input");


                if(sessionStorage.getItem("darkmode_used")=="true")
                {
                    body.style.background = "#292929";
                    body.style.color = "white";
                    for(let oneButtonList of buttonList)
                    {
                        oneButtonList.style.backgroundColor = "#292929";
                    }

                    for(let oneInput of input)
                    {
                        oneInput.style.color = "white";
                    }
                    myonoffswitch.checked = true;
                }

                myonoffswitch.addEventListener("click", function() 
                {
                    if(myonoffswitch.checked)
                    {
                        body.style.background = "#292929";
                        body.style.color = "white";

                        for(let oneButtonList of buttonList)
                        {
                            oneButtonList.style.backgroundColor = "#292929";
                        }

                        for(let oneInput of input)
                        {
                            oneInput.style.color = "white";
                        }
                        sessionStorage.setItem("darkmode_used","true");

                    }else{
                        body.style.background = "white";
                        body.style.color = "#646464";

                        for(let oneButtonList of buttonList)
                        {
                            oneButtonList.style.backgroundColor = "white";
                        }

                        for(let oneInput of input)
                        {
                            oneInput.style.color = "black";
                        }
                        sessionStorage.setItem("darkmode_used","false");
                    }
                    
                });
            });
            
        </script>

        <body> 
<p></p>

        <header>
            <div id='menu'>
                <?php
                // if (session()->get('typeExp') != NULL && session()->get('typeExp') == true) {
                //     echo "<a id='create_compte' href=\"".url('register')."\">Créer un compte</a>";
                // }
                if (session()->get('loginExp') == NULL) {
                    echo "<a href=\"".url('login')."\"></a>";
                } else {
                    echo "<p id='show_account'>Connect as ".session()->get('loginExp')."</p>";
                    // echo "<a id='deco' href=\"".url('logout')."\">Se déconnecter</a>";
                }
                ?>

            <div class="onoffswitch">
                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch">
                <label class="onoffswitch-label" for="myonoffswitch">
                    <span class="onoffswitch-inner"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>

            </div>
            <h1 class="title_header">Annotate Me</h1>
        </header>


        <div class="flex-center position-ref full-height">
            <div class="container">
                
                

                @section('nav') 

                @show 
                <div class="container"> 
                @yield('content') 
                </div> 

                
            </div>


        </div>
           <!--  <footer>Website under construction for the LISTIC lab / CC IUT INFO Annecy</footer> -->

        
    </body> 
    </head>
</html>
