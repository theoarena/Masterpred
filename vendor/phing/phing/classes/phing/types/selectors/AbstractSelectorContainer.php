<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information please see
 * <http://phing.info>.
 */

require_once 'phing/types/selectors/SelectorAware.php';
require_once 'phing/types/selectors/SelectorContainer.php';
require_once 'phing/types/DataType.php';

/**
 * This is the base class for selectors that can contain other selectors.
 *
 * @author Siad Ardroumli <siad.ardroumli@gmail.com>
 * @package phing.types.selectors
 */
abstract class AbstractSelectorContainer extends DataType implements SelectorContainer
{
    use SelectorAware;

    /**
     * Performs the check for circular references and returns the
     * referenced FileSet.
     *
     * @param Project $p
     *
     * @throws BuildException
     *
     * @return FileSet
     */
    public function getRef(Project $p)
    {
        $dataTypeName = StringHelper::substring(get_class(), strrpos(get_class(), '\\') + 1);
        return $this->getCheckedRef(get_class(), $dataTypeName);
    }

    /**
     * Indicates whether there are any selectors here.
     *
     * @return boolean Whether any selectors are in this container
     */
    public function hasSelectors()
    {
        if ($this->isReference() && $this->getProject() !== null) {
            return $this->getRef($this->getProject())->hasSelectors();
        }

        return !empty($this->selectorsList);
    }

    /**
     * Convert the Selectors within this container to a string. This will
     * just be a helper class for the subclasses that put their own name
     * around the contents listed here.
     *
     * @return string comma separated list of Selectors contained in this one
     */
    public function __toString()
    {
        return implode(', ', $this->selectorElements());
    }

    /**
     * <p>
     * This validates each contained selector
     * provided that the selector implements the validate interface.
     * </p>
     * <p>Ordinarily, this will validate all the elements of a selector
     * container even if the isSelected() method of some elements is
     * never called. This has two effects:</p>
     * <ul>
     * <li>Validation will often occur twice.
     * <li>Since it is not required that selectors derive from
     * BaseSelector, there could be selectors in the container whose
     * error conditions are not detected if their isSelected() call
     * is never made.
     * </ul>
     */
    public function validate()
    {
        if ($this->isReference()) {
            $dataTypeName = StringHelper::substring(get_class(), strrpos(get_class(), '\\') + 1);
            $this->getCheckedRef(get_class(), $dataTypeName)->validate();
        }
        $selectorElements = $this->selectorElements();
        $this->dieOnCircularReference($selectorElements, $this->getProject());
        foreach ($selectorElements as $o) {
            if ($o instanceof BaseSelector) {
                $o->validate();
            }
        }
    }

    /**
     * Gives the count of the number of selectors in this container
     *
     * @throws Exception
     * @return int The number of selectors in this container
     */
    public function selectorCount()
    {
        if ($this->isReference() && $this->getProject() !== null) {
            try {
                return $this->getRef($this->getProject())->selectorCount();
            } catch (Exception $e) {
                throw $e;
            }
        }

        return count($this->selectorsList);
    }

    /**
     * Returns the set of selectors as an array.
     *
     * @param Project $p
     * @throws BuildException
     * @return array of selectors in this container
     */
    public function getSelectors(Project $p)
    {
        if ($this->isReference()) {
            return $this->getRef($p)->getSelectors($p);
        } else {
            // *copy* selectors
            $result = [];
            for ($i = 0, $size = count($this->selectorsList); $i < $size; $i++) {
                $result[] = clone $this->selectorsList[$i];
            }

            return $result;
        }
    }

    /**
     * Returns an array for accessing the set of selectors.
     *
     * @return array The array of selectors
     */
    public function selectorElements()
    {
        if ($this->isReference() && $this->getProject() !== null) {
            return $this->getRef($this->getProject())->selectorElements();
        }

        return $this->selectorsList;
    }

    /**
     * Add a new selector into this container.
     *
     * @param FileSelector $selector new selector to add
     *
     * @throws BuildException
     *
     * @return void
     */
    public function appendSelector(FileSelector $selector)
    {
        if ($this->isReference()) {
            throw $this->noChildrenAllowed();
        }
        $this->selectorsList[] = $selector;
    }

    public function dieOnCircularReference(&$stk, Project $p)
    {
        if ($this->checked) {
            return;
        }

        if ($this->isReference()) {
            parent::dieOnCircularReference($stk, $p);
        } else {
            foreach ($this->selectorsList as $fileSelector) {
                if ($fileSelector instanceof DataType) {
                    self::pushAndInvokeCircularReferenceCheck($fileSelector, $stk, $p);
                }
            }
            $this->checked = true;
        }
    }
}
