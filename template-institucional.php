<?php 
//Template Name: Página institucional
get_header();
$fields = get_fields();?>

    <main class='container text-center'>
        <?php  
            if(have_posts(  )){
                while(have_posts(  )){
                    the_post(  );
                }
            }
        ?>

        <h1 class='my-5'><?php echo $fields['titulo'];?></h1>
        <img src="<?php echo $fields['imagen']?>" alt=""></img>
        <hr>

        <div class='text-justify'>
             <div class='col'>
        <?php the_content( );?>
            </div>
            </div>
    </main>
    

  
   
<?php get_footer();?>
