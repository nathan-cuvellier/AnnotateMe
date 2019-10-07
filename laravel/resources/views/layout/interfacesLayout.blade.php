<!doctype html>
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

            //DarkMode
                document.addEventListener("DOMContentLoaded", function() 
                {
                    var body = document.querySelector("body");
                    var a = document.querySelector("a");
                    var onoffswitch = document.querySelector(".onoffswitch");
                    var myonoffswitch = document.querySelector("#myonoffswitch");

                    
                    if(sessionStorage.getItem("darkmode_used")=="true")
                    {
                        body.style.background = "#292929";
                        body.style.color = "white";
                        
                        myonoffswitch.checked = true;
                    }


                    myonoffswitch.addEventListener("click", function() 
                    {
                        if(myonoffswitch.checked)
                        {
                            body.style.background = "#292929";
                            body.style.color = "white";
                            sessionStorage.setItem("darkmode_used","true");
                        }
                        else
                        {
                            body.style.background = "white";
                            body.style.color = "#646464";
                            sessionStorage.setItem("darkmode_used","false");
                        }
                        
                    });
                });

        </script>
        @if(session()->has('nb_annot_limit'))
                <p id="nb_annot_limit">Remaining annotations: {{session()->get('nb_annot_limit')}}</p>
        @endif

        @if($now !== null)
            <!-- TIMER -->
                <p id="timer"></p>    

                <script>


                var valueTimer = <?php echo ("\"$prj->limit_prj\"")?>;


                var second = new Date(<?php echo ("\"$now\"")?>).getSeconds();
                var minute = new Date(<?php echo ("\"$now\"")?>).getMinutes();
                var hour = new Date(<?php echo ("\"$now\"")?>).getHours();


                // Set the date we're counting down to
                var countDownDate = second + 60 * minute + hour*3600;
                console.log(minute+" - "+ hour );


                if(localStorage.getItem("distance") == 0)
                {
                    countDownDate = countDownDate;
                    document.getElementById("timer").innerHTML = valueTimer + "m 00s ";
                }
                else if(localStorage.getItem("distance") >= 0)
                {
                    countDownDate = countDownDate - (valueTimer*60 - localStorage.getItem("distance"));
                    document.getElementById("timer").innerHTML = Math.floor((localStorage.getItem("distance") / 60 )) + "m " + Math.floor((localStorage.getItem("distance") % 60)) + "s ";
                }
                else
                {
                    <?php session()->put('message','You have completed your annotation session (Out of time). Thank you!'); ?>
                    
                    window.location = "../..";
                }

                



                // Update the count down every 1 second
                var x = setInterval(function() {
                    console.log(localStorage.getItem("distance"));
                    // Get todays date and time
                    
                    // Find the distance between now and the count down date

                    var currentSecond = new Date().getSeconds();
                    var currentMinute = new Date().getMinutes();
                    var currentHour = new Date().getHours();


                    var now = currentSecond + currentMinute*60 + currentHour*3600;

                    distance = countDownDate - now;


                    

                    // Time calculations for days, hours, minutes and seconds
                    // console.log(distance);
                    var minutes = Math.floor((distance / 60 ));
                    var seconds = Math.floor((distance % 60));

                    // Display the result in the element with id="timer"
                    document.getElementById("timer").innerHTML = minutes + "m " + seconds + "s ";
                    // secondDistance = Math.round(distance/1000);

                    // If the count down is finished, write some text
                    if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("timer").innerHTML = "EXPIRED";
                    }



                }, 1000);

                
                

                </script>

        @endif

        <script type="text/javascript">
            //Keep the value of the timer for the next annotation 
            function timeStorage()
            {
                localStorage.setItem("distance",  distance);
            }
        </script>

        <body>

      
        <header>
            <div id='menu'>
                <?php  
                    echo "<p id='show_account'>Connect as ".session()->get('loginExp')."</p>";
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
                    <div class="annotFooter">
                        <input  id="validate" class="myButton tripleform" type="submit" value="Validate" onclick="timeStorage()">
                        <div  id="quitAnnote" class="myButton tripleform" value="Quit">Quit</div>
                        <script type="text/javascript">
                            let quit = document.querySelector("#quitAnnote")
                            quit.addEventListener("click",function()
                            {
                                <?php session()->put('message','You have left your annotation session. See you soon!'); ?>
                                window.location = "../..";
                                localStorage.setItem("distance",  0);
                            })
                        </script>    
                        <p class="interval">Expert sample confidence level :<br> <input class="intervalle_input" id="numberconf" name="confiance" type="range" min="0" max="2" step="1" value="{{$oldConfiance}}"><div id="trust"><p id="doubt">doubt</p><p id="confident">confident</p><p id="very_confident">highly confident</p></div></p>
                    </div>
                    </form>
                </div> 

                
            </div>


        </div>

           

        
    </body> 
    </head>
</html>