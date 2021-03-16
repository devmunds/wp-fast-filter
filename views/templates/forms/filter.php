<div class="filter-content">
    <div class="filter-wrap">
        <form action="" class="filter-form">
            <select name="filter-year" id="filter-year">
                <option value="<?php echo date( 'Y' );?>">Ano</option>
                <?php     
                for ($i = date("Y"); $i >= 2000; $i--) {
                
                    print('"<option value="' . $i .'""');

                        if($editar['year'] == $i){
                                print "selected";
                            }
                    print ">$i</option>";		         
                } 
                ?>
            </select>
            <select name="filter-month" id="filter-year">
                <option value="<?php echo date( 'M' );?>">Mês</option>
                <?php     
                for ($i = 1; $i <= 12; $i++) {
                
                    print('"<option value="' . $i .'""');

                        if($editar['month'] == $i){
                                print "selected";
                            }
                    print ">$i</option>";		         
                } 
                ?>
            </select>        
            <input type="submit" value="Pesquisar" id="filter-submit">
        </form>
    </div>   