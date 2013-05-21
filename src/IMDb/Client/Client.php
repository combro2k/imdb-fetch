<?php

namespace IMDb\Client;

use \Bluelyte\IMDB\Client\Client as BaseClient;

class Client extends BaseClient
{
    /**
     * Select specific fields in the CSV which will only be imported
     *
     * @var array $listReturnedFields
     */
    protected $listReturnedFields = array(
        'description',
        'Directors',
        'IMDb Rating',
        'Genres',
        'Title',
        'Title type',
        'URL',
        'Runtime (mins)',
        'Year',
    );

    /**
     * Returns information for a specified TV show.
     *
     * @param string $id ID as contained in the URL for the list of the
     *        form http://www.imdb.com/list/ID/
     * @return array Associative array of the list
     */
    public function getList($id)
    {
        $crawler = $this->request('GET', $this->baseUrl.'/list/'.$id);
        $exportFile = $crawler->filterXPath('//div[contains(@class, "see-more")]/div[contains(@class, "create")]/div[@class="export"]/a')->attr('href');

        $csvExport = file_get_contents($this->baseUrl.$exportFile);

        foreach (explode("\n", $csvExport) as $csvRow) {
            if (!isset($headers)) {
                // first row will ALWAYS be header unless csv is changed
                $headers = str_getcsv($csvRow);
            } elseif ($csvRow) {
                $data = str_getcsv($csvRow);
                foreach ($data as $key => $value) {
                    $key = $headers[$key];
                    if (in_array($key, $this->listReturnedFields)) {
                        $temp[$key] = $value;
                    }
                }

                if (isset($temp)) {
                    $return[] = $temp;
                    unset($temp);
                }
            }
        }

        return isset($return) ? $return : false;
    }
}
