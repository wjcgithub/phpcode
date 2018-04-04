<?php

namespace RemoteProxy;

/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 18-4-4
 * Time: 下午3:41
 */
interface LibraryInterface
{
    /**
     * Return the books
     *
     * @Endpoint(path="books")
     */
    public function getBooks();

    /**
     * Return book's details
     *
     * @Endpoint(path="books/:id")
     * @param  int $id
     * @return mixed
     */
    public function getBook($id);

    /**
     * Return author of a book
     *
     * @Endpoint(path="books/:id/authors")
     * @param  int $id
     * @return mixed
     */
    public function getAuthors($id);
}