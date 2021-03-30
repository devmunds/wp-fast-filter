<div class="nav-menu-pagination">
    <ul>
        <li class="text-left"><?php previous_posts_link( __( '« Pagina anterior', 'wp-fast-filter' ) ) ?></li>
        <li class="text-right"><?php next_posts_link( __( 'Próxima pagina »', 'wp-fast-filter' ), $query->max_num_pages ) ?></li>
    </ul>
</div>
