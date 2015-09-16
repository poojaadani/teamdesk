<html><head>
<title>Team desk</title>
<link rel="stylesheet" href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">


    <!--//
    $(document).ready(function () {

        //your code here
        var authtoken = "55B457BD58AB45179D6307EEBCA76DC3";
        $("#mydrop").change(function ()
        {
            var conceptName = $('#mydrop').find(":selected").val();

            $.getJSON("https://www.teamdesk.net/secure/api/v2/44101/"+ authtoken+"/Products/select.json", function(data)
            {
                for(var item in data)
                {

                    if (data.hasOwnProperty(item)) {
                        {
                            for(var item1 in data[item])
                            {
                                //console.log("item1"+item1);
                                if(item1 == "ProId" && data[item][item1] == conceptName)
                                {
                                    price = data[item]["CusPrice"];

                                    //cusprice
                                    $('input[name="price"]').val(price);
                                    //$('#price').val(unit * price);

                                }


                            }
                        }

                    }


                }


            });
        });
        $( "#units" ).keyup(function() {
            var unit =$('#units').val();
            /*var conceptName = $('#mydrop').find(":selected").val();
             var  authtoken ="55B457BD58AB45179D6307EEBCA76DC3";*/
            var price=$('#price').val();
            $('#total').val(unit * price);

        });


    });







//alert(price);


    function save()
    {
        var name =$('#name').val();
        var unit =$('#units').val();
        var conceptName = $('#mydrop').find(":selected").val();
        var total =$('#total').val();
        var cusprice =$('#price').val();
        var cust_id='';
        var data =
            {"CustName": name}


        $.post('https://www.teamdesk.net/secure/api/v2/44101/55B457BD58AB45179D6307EEBCA76DC3/Customers/create.json', data, function(response) {

            for (var i in response)
            {
                cust_id = response[i]["id"];
                var oredr_data = {CustName: cust_id, "ProName": conceptName,"Units": unit,"CustPrice": cusprice,"Total": total};

                $.post('https://www.teamdesk.net/secure/api/v2/44101/55B457BD58AB45179D6307EEBCA76DC3/Orders/create.json', oredr_data, function(response) {
                    // Do something with the request
                }, 'json');

            }
            $('#name').val("");
            $('#units').val("");
            $('#total').val("");
            $('#price').val("");
            $('#mydrop').val("Please select one..");

        }, 'json');


    }


    //-->

</script>

<?php


$authtoken = "55B457BD58AB45179D6307EEBCA76DC3";
$data = json_decode(file_get_contents(
"https://www.teamdesk.net/secure/api/v2/44101/". $authtoken."/Products/select.json"));

?>
</head>
<body >

<div class="container">



<h3 ng-hide="edit">Create Information:</h3>

<form class="form-horizontal">
  <div class="form-group">
    <label class="col-sm-2 control-label">Customer Name:</label>
    <div class="col-sm-10">
    <input type="text" ng-model="fName" id="name" placeholder="Enter Name">
    </div>
  </div> 
  <div class="form-group">
    <label class="col-sm-2 control-label">Product Name:</label>
    <div class="col-sm-10">
        <select id="mydrop">
            <option>Please select one..</option>
            <?php
            foreach($data as $key=>$value)
            {

                echo "<option value='" . $value->ProId . "'>" . $value->ProName. "</option>";
            }

            ?>
        </select>
    </div>
  </div>
    <div class="form-group">


            <label class="col-sm-2 control-label">Price:</label>
            <div class="col-sm-10">
            <input type="text" id="price" name="price" readonly>
                <input type="hidden" id="cusprice" name="cusprice">
            </div>
            </div>


  <div class="form-group">
    <label class="col-sm-2 control-label">Units:</label>
    <div class="col-sm-10">
    <input type="text" id="units" placeholder="Units">
    </div>

</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Total:</label>
    <div class="col-sm-10">
        <input type="text" id="total" placeholder="Total" readonly>
    </div>
</div>


</form>

<hr>

<button class="btn btn-success"  onclick="save();">
<span class="glyphicon glyphicon-save"></span>  Save Changes
</button>

</div>



</body>
</html>
