<?php
/*
 * Template Name: Custom Full Width
 * description: >-
  Page template without sidebar
 */

get_header('custom'); ?>

   <div id="primary" class="content-area">
   <div v-scope="{ count: 0 }">
   {{ count }}
   <button @click="count++">inc</button>
   </div>


   <main id="main" class="site-main" role="main">

   <?php
   // Start the loop.
   while ( have_posts() ) : the_post();

   // Include the page content template.
   get_template_part( 'content', 'page' );

   // If comments are open or we have at least one comment, load up the comment template.
   if ( comments_open() || get_comments_number() ) :
      comments_template();
   endif;

   // End the loop.
   endwhile;
   ?>

   </main><!-- .site-main -->
   </div><!-- .content-area -->

<?php get_footer('custom'); ?>


<script>
  PetiteVue.createApp().mount()
</script>
