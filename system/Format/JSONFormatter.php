<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\Format;

use CodeIgniter\Format\Exceptions\FormatException;
use Config\Format;

/**
 * JSON data formatter
 *
 * @see \CodeIgniter\Format\JSONFormatterTest
 */
class JSONFormatter implements FormatterInterface
{
    /**
     * Takes the given data and formats it.
     *
     * @param array|bool|float|int|object|string|null $data
     *
     * @return false|string (JSON string | false)
     */
    public function format($data)
    {
        $config = new Format();

        // Ensure data is UTF-8 encoded
        $data = $this->ensureUTF8($data);

        $options = $config->formatterOptions['application/json'] ?? JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
        $options |= JSON_PARTIAL_OUTPUT_ON_ERROR;

        $options = ENVIRONMENT === 'production' ? $options : $options | JSON_PRETTY_PRINT;

        $result = json_encode($data, $options, 512);

        if (! in_array(json_last_error(), [JSON_ERROR_NONE, JSON_ERROR_RECURSION], true)) {
            throw FormatException::forInvalidJSON(json_last_error_msg());
        }

        return $result;
    }

    /**
     * Recursively ensure all strings are UTF-8 encoded
     */
    private function ensureUTF8($data)
    {
        if (is_string($data)) {
            return mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->ensureUTF8($value);
            }
        }

        if (is_object($data)) {
            foreach ($data as $key => $value) {
                $data->$key = $this->ensureUTF8($value);
            }
        }

        return $data;
    }
}
