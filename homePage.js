/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
        var dataArray = [10];
        var height = 300;
        var toggled = false;
        
        function sleep(miliseconds) {
           var currentTime = new Date().getTime();

           while (currentTime + miliseconds >= new Date().getTime()) {
           }
       }
       
       var opacityTimer = 0;
 
        function animationLoop1() {

            if (opacityTimer > 1) {
                opacityTimer = 1;
            } else {
                opacityTimer += .015;
            }

            if(opacityTimer == 1){
                document.getElementById('aboutMe').style.opacity = 1;
                opacityTimer = 0;

                return;
            }

            requestAnimationFrame(animationLoop1);
        }
        
        function animationLoop2() {

            if (opacityTimer > 1) {
                opacityTimer = 1;
            } else {
                opacityTimer += .015;
            }

            if(opacityTimer == 1){
                document.getElementById('family').style.opacity = 1;
                opacityTimer = 0;

                return;
            }

            requestAnimationFrame(animationLoop2);
        }    
        
        var margin = {top: 300, right: 600, bottom: 300, left: 600};
        var width = screen.width;
        var height = screen.height;
        
        var svg = d3.select("body").append("svg")
            .attr("width", margin.left + margin.right)
            .attr("height", margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate("+ (margin.top/height) * height + ", 0)");
    
        var board = svg.selectAll("rect")
                   .data(dataArray)
                   .enter()
                       .append("rect")
                       .attr("width", (900/width) * width)
                       .attr("height", (600/height) * height)
                       .attr("fill", "#F2AE72")
                       .attr("id", "board")
                       .attr("y", height / 25)
                       .text("I dont think this text is working but lets see");
               
             board.on("click", function(d, i){
                         d3.select(this)
                              .transition()
                              .duration(500)
                                 .attr("height", function(d, i){
                                     return 0;
                                 })
                                 .attr("transform", "translate(0,300)")
                                 .transition()
                                 .duration(100)
                                 .attr("fill", function(d, i) { 
                                     if (toggled == false ){
                                         return "#D96459";
                                     }
                                     
                                     else 
                                     {
                                         return "#F2AE72";
                                     }
                                })
                              .transition()
                              .duration(500)
                                 .attr("height", function(d, i){
                                     return 600;
                                 })
                                 .attr("transform", "translate(0,0)");
                        
                d3.select(this).transition()
                                 .delay(2000)
                                 .call(function(d, i){
                                if (toggled == false ){
                                    toggled = true;
                                    document.getElementById('aboutMe')
                                            .style.opacity = 0;
                                    animationLoop2();
                                     }
                                     
                                else{
                                    toggled = false;
                                     document.getElementById('family')
                                            .style.opacity = 0;
                                    animationLoop1();
                                     }
                                 });
                     });
