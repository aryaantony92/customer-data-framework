<?php
/**
 * Created by PhpStorm.
 * User: mmoser
 * Date: 07.10.2016
 * Time: 13:37
 */

namespace CustomerManagementFramework\Model;

use Carbon\Carbon;
use CustomerManagementFramework\ActivityStoreEntry\ActivityStoreEntryInterface;
use CustomerManagementFramework\Factory;
use Pimcore\Model\Object\CustomerSegmentGroup;

abstract class AbstractTermSegmentBuilderDefinition extends \Pimcore\Model\Object\Concrete {

    /**
     * @return array
     */
    public function definitionsToArray()
    {
        $result = [];

        if($terms = $this->getTerms()) {
            foreach($terms as $term) {
                $result[$term['term']->getData()] = isset($result[$term['term']->getData()]) ? $result[$term['term']->getData()] : [];
                $phrases = $term['phrases']->getData();
                if(sizeof($phrases)) {
                    $phrases = array_column($phrases, 0);
                    $result[$term['term']->getData()] = array_merge($result[$term['term']->getData()], $phrases);
                }
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getAllTerms()
    {
        $result = [];
        foreach($this->definitionsToArray() as $term => $phrases) {
            $result[] = $term;
        }
        return array_unique($result);
    }

    /**
     * @return array
     */
    public function getAllPhrases()
    {
        $result = [];
        foreach($this->definitionsToArray() as $phrases) {
            $result = array_merge($result, (array)$phrases);
        }
        return array_unique($result);
    }

    /**
     * @param array $phrases
     *
     * @return array
     */
    public function getMatchingPhrases(array $phrases)
    {
        $allPhrases = $this->getAllPhrases();

        $result = [];

        foreach($phrases as $term) {
            foreach($allPhrases as $_term) {

                if($term == $_term) {
                    $result[] = $term;
                    break;
                }

                if(@preg_match($_term, $term)){
                    $result[] = $term;
                    break;
                }
            }
        }

        $result = array_unique($result);

        return $result;
    }

    /**
     * Adds/deletes CustomerSegment objects within given $customerSegmentGroup depending on defined terms within this TermSegmentBuilderDefinition.
     *
     * @param CustomerSegmentGroup $customerSegmentGroup
     * @return void;
     */
    public function updateCustomerSegments(CustomerSegmentGroup $customerSegmentGroup)
    {
        $terms = $this->getAllTerms();
        $currentSegments = Factory::getInstance()->getSegmentManager()->getSegmentsFromSegmentGroup($customerSegmentGroup);

        $updatedSegments = [];
        foreach($terms as $term) {
            $updatedSegments[] = Factory::getInstance()->getSegmentManager()->createSegment($term, $customerSegmentGroup, $term, $customerSegmentGroup->getCalculated());
        }

        // remove all entries from $updaedSegments from $currentSegments
        foreach($currentSegments as $key => $currentSegment) {
            foreach($updatedSegments as $updatedSegment) {
                if($currentSegment->getId() == $updatedSegment->getId()) {
                    unset($currentSegments[$key]);
                    break;
                }
            }
        }

        // delete remaining entries from $currentSegments as they are not relevant anymore
        foreach($currentSegments as $currentSegment) {
            $currentSegment->delete();
        }
    }


}