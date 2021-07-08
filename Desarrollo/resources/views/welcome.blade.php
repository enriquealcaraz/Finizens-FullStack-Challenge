<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Finizens</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/node-uuid/1.4.7/uuid.min.js"></script>
        <script
          src="https://code.jquery.com/jquery-3.6.0.js"
          integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
          crossorigin="anonymous"></script>
    </head>
    <body class="antialiased">
        <hr />
        <div class="container">
            <button class="btn btn-primary" id="btnReboot">Reboot portfolio</button>
        </div>
        <hr />
        <div class="container">
        <h3>Allocations</h3>
        <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Portfolio</th>
                <th scope="col">Allocation</th>
                <th scope="col">shares</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="allocation">
            </tbody>
        </table>
        </div>        
        <div class="container">
        <h3>Orders</h3>
        <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Portfolio</th>
                <th scope="col">Allocation</th>
                <th scope="col">shares</th>
                <th scope="col">Type</th>
                <th scope="col">status</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="order">
            </tbody>
        </table>
        </div>
    </body>
    <script>
    $(document).ready(function() {    
        
        $.ajax({
            url: 'http://localhost:8080/portfolio/1',
            success: function(response) {
                var data = JSON.parse(response); 
                var tableAllocations = '';
                $.each(data.allocations, function (ind, elem) {
                    var order = Math.round(Math.random() * (999999 - 1) + 1);
                    tableAllocations += '<tr>' +
                    '<td>' + data.id + '</td>' +
                    '<td>' + elem.id + '</td>' +
                    '<td>' + elem.shares + '</td>' +
                    '<td><button data-id="'+order+'" data-shares="' + elem.shares + '" data-allocation="' + elem.id + '" data-portfolio="' + data.id + '" class="btn btn-primary" id="btnSell">Sell all</button>' + 
                    '<br />Generate with orderId '+order+'</td>' +
                    '</tr>';
                }); 

                $('#allocation').html(tableAllocations);
            },
            error: function() {
                console.log("The information could not be obtained");
            }
        });
        
        $.ajax({
            url: 'http://localhost:8080/orders/1',
            success: function(response) {
                var data = JSON.parse(response); 
                var tableOrder = '';
                $.each(data, function (ind, elem) {
                    if (elem.status == 0) {
                        tableOrder += '<tr>' +
                        '<td>' + elem.id + '</td>' +        
                        '<td>' + elem.portfolio + '</td>' +
                        '<td>' + elem.allocation + '</td>' +
                        '<td>' + elem.shares + '</td>' +
                        '<td>' + elem.type + '</td>' +
                        '<td>' + elem.status + '</td>' +
                        '<td><button data-id="' + elem.id + '" class="btn btn-primary" id="btnComplete">Complete</button></td>' + 
                        '</tr>';
                    }
                    
                }); 

                $('#order').html(tableOrder);
            },
            error: function() {
                console.log("The information could not be obtained");
            }
        });
        
        $(document).on('click', '#btnComplete', function()
        {
            $.ajax({
                type:"POST",
                url:"http://localhost:8080/complete",
                data: JSON.stringify ({id: this.dataset.id}),
                success:function(data){                    
                },
                contentType : 'application/json',
            });
            location.reload();
        });
        
        $(document).on('click', '#btnSell', function()
        {
            $.ajax({
                type:"POST",
                url:"http://localhost:8080/sell",
                data: JSON.stringify ({
                    id: this.dataset.id,
                    portfolio: this.dataset.portfolio,
                    allocation: this.dataset.allocation,
                    shares: this.dataset.shares
                }),
                success:function(data){                    
                },
                contentType : 'application/json',
            });
            location.reload();
        });

        $(document).on('click', '#btnReboot', function()
        {            
            var allocations = [
                { 'id': 1, 'shares': 3}
              , { 'id': 2, 'shares': 4}
            ];

            $.ajax({
                type:"PUT",
                url:"http://localhost:8080/portfolio",
                data: JSON.stringify ({
                    id: 1,
                    allocations: allocations                    
                }),
                success:function(data){                    
                },
                contentType : 'application/json',
            });
            location.reload();
        });        
 });       
    </script>
</html>
