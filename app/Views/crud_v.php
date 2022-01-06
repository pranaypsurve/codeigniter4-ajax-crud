<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Demo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-5">
                <form method="post"> 
                <div class="form-group">
                    <label for="">First Name</label>
                    <input type="text" name="fname" class="form-control" id="fname" required>
                </div>
                <div class="form-group">
                    <label for="">Last Name</label>
                    <input type="text" name="lname" class="form-control" id="lname" required>
                </div>
                <div class="form-group">
                    <label for="">City</label>
                    <input type="text" name="city" class="form-control" id="city" required>
                </div>
                <div class="form-group">
                    <input type="submit"value='Submit' class="btn btn-primary" id="submit" required>
                </div>
                </form>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tr>
                        <th>id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>City</th>
                        <th>Actions</th>
                    </tr>
                    <tbody id='tablebody'>
                        <?php if(!empty($allData)): ?>
                        <?php foreach($allData as $key => $value){ ?>
                        <tr>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['fname'] ?></td>
                            <td><?= $value['lname'] ?></td>
                            <td><?= $value['city'] ?></td>
                            <td class="onEditDis"><a onclick = "handleEdit(event,<?= $value['id'] ?>)" class="btn btn-success">Edit</a> | <a onclick = "handleDelete(event,<?= $value['id'] ?>)" class="btn btn-danger" >Delete</a></td>
                        </tr>
                        <?php } ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No Data</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>


<!-- js code start -->
<script type="text/javascript">
$('document').ready(function(){

    $('form').on('submit',function(e){
        e.preventDefault(); 
        // form submiter 
        // send with ajax
       
        $.ajax({
            type:'post',
            url:'<?= base_url().'/Home/insert' ?>',
            data:$('form').serialize(),
            success:function(res){
                if($("input[type='hidden']").length){
                    $("input[type='hidden']").remove();
                }
                showData();
            },
            complete:function(){
                $('form')[0].reset();
                $('#tablebody').css('opacity','1');
                $('#submit').val('Submit');
                $('.onEditDis').css('display','block');
            }
        });
    });
});
function handleDelete(e,id){
    e.preventDefault(); 
    $.ajax({
            url:'<?= base_url().'/index.php/Home/delete/' ?>' + id ,
            data:$('form').serialize(),
            success:function(){
                showData();
            },
            complete:function(){
            }
        });    
}
function handleEdit(e,id){
    e.preventDefault(); 
    $('<input>').attr({
    type: 'hidden',
    id: 'id',
    name: 'id',
    value: id
}).appendTo('form');
    $.ajax({
            url:'<?= base_url().'/index.php/Home/edit/' ?>' + id ,
            data:$('form').serialize(),
            success:function(res){
                res = JSON.parse(res);
                $('#fname').val(res.fname);
                $('#lname').val(res.lname);
                $('#city').val(res.city);
                $('#submit').val('Update');
                $('#tablebody').css('opacity','0.5');
                // showData();
            },
            complete:function(){
                // $('form')[0].reset();
                
                $('.onEditDis').css('display','none');
            }
        });    
}
    function showData(){
        $.ajax({
            type:'get',
            url:'<?= base_url().'/index.php/Home/getData' ?>',
            data:$('form').serialize(),
            success:function(res){
                let result = JSON.parse(res);
                console.log(result);
                let html = '';
                if(result.length == 0){
                    html += '<tr> <td colspan="5"> No Data Found </td></tr>'
                }else{
                    for(var i = 0; i < result.length; i++){
                        // console.log(result.length);
                        html += '<tr> <td>'+ result[i].id +'</td><td>'+ result[i].fname +'</td><td>'+ result[i].lname +'</td> <td>'+ result[i].city +'</td>'
                        + '<td class="onEditDis"> <a href="/edit/'+ result[i].id +'" onclick = "handleEdit( event ,'+ result[i].id + ' )" class="btn btn-success">Edit</a> | <a onclick = "handleDelete( event ,'+ result[i].id + ' )" class="btn btn-danger">Delete</a> </td></tr>';
                    }
                }
                $('#tablebody').html(html);
            },
            complete:function(){
                $('form')[0].reset();
                $('.onEditDis').css('display','block');
            }
        });
    }
</script>









