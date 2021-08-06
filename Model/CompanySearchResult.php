<?php
declare(strict_types=1);
namespace Devall\Company\Model;

use Magento\Framework\Api\SearchResults;
use Devall\Company\Api\Data\CompanySearchResultInterface;

/**
 * Class CompanySearchResult
 * @package Devall\Company\Model
 */
class CompanySearchResult extends SearchResults implements CompanySearchResultInterface
{}
