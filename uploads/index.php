<?php
    include "../config.php";
?>

<html>
    <head>
        <title></title>

        <?php
            if(isset($_POST['but_import'])){
                
                echo 'this time-'. date("h:i:sa");
                $target_file = "../Book.csv";
                        
                //check file exists
                $fileexists = 0;
                if(file_exists($target_file)){
                    $fileexists = 1;
                }

                if($fileexists == 1){

                    //Reading the file
                    $file = fopen($target_file, "r");
                    $index = 0;
                    $importData_arr = array();

                    while(($data = fgetcsv($file, 1000,",")) != FALSE){
                        $num = count($data);
                        if($index != 0){
                            for($c = 0; $c < $num; $c++){
                                $importData_arr[$index][] = $data[$c];
                            }
                        }
                       
                        $index++;
                    }
                    fclose($file);

                    $sql_array = array();
                    foreach($importData_arr as $data){

                            $ID = $data[0];
                            $Title = $data[1];
                            $Content = $data[2];
                            $ShortDescription = $data[3];
                            $Sku = $data[4];
                            $Stock = $data[5];
                            $RegularPrice = $data[6];
                            $AttributeName_pa_bisac_codes = $data[7];


                            //Checking entry
                            $checkUser = "Select count(*) as allcount from csvdata where ID = '".$ID."'";
                            $retrieve_data = mysqli_query($con, $checkUser);
                            $row = mysqli_fetch_assoc($retrieve_data);
                            $count = $row['allcount'];

                            // if($count == 0)
                            // {
                                //Insert record
                                $sql_array[] = "( '".$ID."', '".$Title."', '".$Content."', '".$ShortDescription."', '".$Sku."', '".$Stock."', '".$RegularPrice."', '".$AttributeName_pa_bisac_codes."')";
                                
                                if(count($sql_array) >= 1000) {
                                    $query_single = $sql_start . implode(', ', $sql_array);
                                    mysqli_query($con, $query_single);
                                    $sql_array = array();
                                }

                                // mysqli_query($con, "Insert into csvdata(ID, Title, Content, ShortDescription, Sku, Stock, RegularPrice, AttributeName_pa_bisac_codes) values ( '".$ID."', '".$Title."', '".$Content."', '".$ShortDescription."', '".$Sku."', '".$Stock."', '".$RegularPrice."', '".$AttributeName_pa_bisac_codes."')");
                            // }
                            // else
                            // {
                                //update record
                                // mysqli_query($con, "update csvdata set Content = '".$Content."' where ID = '".$ID."'");
                            // } 
                            

                        // //Delete file after import
                        // if(file_exists($target_file)){
                        //     unlink($target_file);
                        // }

                        // Insert record
                        // mysqli_query($con, "Insert into csvdata(ID, Title, Content, ShortDescription, Sku, Stock, RegularPrice, SalePrice, 
                        // AttributeName_pa_bisac_codes, AttributeValue_pa_bisac_codes, AttributeInVariations_pa_bisac_codes, AttributeIsVisible_pa_bisac_codes, AttributeIsTaxonomy_pa_bisac_codes, AttributeName_pa_book_author,AttributeValue_pa_book_author, AttributeInVariations_pa_book_author, AttributeIsVisible_pa_book_author, AttributeIsTaxonomy_pa_book_author,
                        // AttributeName_pa_copyright_year, Attribute_pa_copyright_year, Attribute,Attribute,Attribute,Attribute,Attribute,Attribute,Attribute,Attribute,
                        // Attribute,Attribute,Attribute,Attribute,Attribute,Attribute,Attribute,Attribute,Attribute,Attribute,
                        // Attribute,Attribute,Attribute,Attribute,Attribute,Attribute,Attribute,Attribute,Attribute,Attribute,
                        // Attribute,Attribute,Attribute,Attribute,Attribute,) values( '".$ID."', '".$Title."', '".$Content."', '".$ShortDescription."', '".$Sku."', '".$Stock."', '".$RegularPrice."')");
                    }
                    echo date("h:i:sa");
                }

            }
            
        ?>
    </head>
    <body>
        <form method="post" action='' enctype="multipart/form-data">
            <input type="file" name=""><br>
            <input type="submit" name="but_import" value="Import">   
        </form>
    </body>
</html>
