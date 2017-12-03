<?php
/*
 *  $Id$
 *
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

require_once 'phing/Task.php';
require_once 'phing/types/selectors/SelectorContainer.php';
include_once 'phing/types/FileSet.php';
include_once 'phing/types/PatternSet.php';
include_once 'phing/util/DirectoryScanner.php';

/**
 * This is an abstract task that should be used by all those tasks that
 * require to include or exclude files based on pattern matching.
 *
 * This is very closely based on the ANT class of the same name.
 *
 * @author    Hans Lellelid <hans@xmpl.org> (Phing)
 * @author    Arnout J. Kuiper <ajkuiper@wxs.nl> (Ant)
 * @author    Stefano Mazzocchi  <stefano@apache.org> (Ant)
 * @author    Sam Ruby <rubys@us.ibm.com> (Ant)
 * @author    Jon S. Stevens <jon@clearink.com> (Ant
 * @author    Stefan Bodewig <stefan.bodewig@epost.de> (Ant)
 * @author    Bruce Atherton <bruce@callenish.com> (Ant)
 * @version   $Id$
 * @package   phing.tasks.system
 */
abstract class MatchingTask extends Task implements SelectorContainer
{

    /** @var boolean */
    protected $useDefaultExcludes = true;

    /** @var FileSet */
    protected $fileset;

    /**
     * Create instance; set fileset to new FileSet.
     */
    public function __construct()
    {
        $this->fileset = new FileSet();
    }

    /**
     * @see ProjectComponent::setProject()
     * @param Project $project
     */
    public function setProject($project)
    {
        parent::setProject($project);
        $this->fileset->setProject($project);
    }

    /**
     * add a name entry on the include list
     * @return PatternSetNameEntry
     */
    public function createInclude()
    {
        return $this->fileset->createInclude();
    }

    /**
     * add a name entry on the include files list
     * @return PatternSetNameEntry
     */
    public function createIncludesFile()
    {
        return $this->fileset->createIncludesFile();
    }

    /**
     * add a name entry on the exclude list
     * @return PatternSetNameEntry
     */
    public function createExclude()
    {
        return $this->fileset->createExclude();
    }

    /**
     * add a name entry on the include files list
     * @return PatternSetNameEntry
     */
    public function createExcludesFile()
    {
        return $this->fileset->createExcludesFile();
    }

    /**
     * add a set of patterns
     * @return PatternSet
     */
    public function createPatternSet()
    {
        return $this->fileset->createPatternSet();
    }

    /**
     * Sets the set of include patterns. Patterns may be separated by a comma
     * or a space.
     *
     * @param  string $includes the string containing the include patterns
     * @return void
     */
    public function setIncludes($includes)
    {
        $this->fileset->setIncludes($includes);
    }

    /**
     * Sets the set of exclude patterns. Patterns may be separated by a comma
     * or a space.
     *
     * @param string $excludes the string containing the exclude patterns
     */
    public function setExcludes($excludes)
    {
        $this->fileset->setExcludes($excludes);
    }

    /**
     * Sets whether default exclusions should be used or not.
     *
     * @param boolean $useDefaultExcludes "true"|"on"|"yes" when default exclusions
     *                                    should be used, "false"|"off"|"no" when they
     *                                    shouldn't be used.
     */
    public function setDefaultexcludes($useDefaultExcludes)
    {
        $this->useDefaultExcludes = (boolean) $useDefaultExcludes;
    }

    /**
     * Returns the directory scanner needed to access the files to process.
     * @param PhingFile $baseDir
     * @throws BuildException
     * @return DirectoryScanner
     */
    protected function getDirectoryScanner(PhingFile $baseDir)
    {
        $this->fileset->setDir($baseDir);
        $this->fileset->setDefaultexcludes($this->useDefaultExcludes);

        return $this->fileset->getDirectoryScanner($this->project);
    }

    /**
     * Sets the name of the file containing the includes patterns.
     *
     * @param  PhingFile $includesfile A string containing the filename to fetch
     *                                 the include patterns from.
     * @return void
     */
    public function setIncludesfile(PhingFile $includesfile)
    {
        $this->fileset->setIncludesfile($includesfile);
    }

    /**
     * Sets the name of the file containing the includes patterns.
     *
     * @param  PhingFile $excludesfile A string containing the filename to fetch
     *                                 the include patterns from.
     * @return void
     */
    public function setExcludesfile(PhingFile $excludesfile)
    {
        $this->fileset->setExcludesfile($excludesfile);
    }

    /**
     * Sets case sensitivity of the file system
     *
     * @param  boolean $isCaseSensitive "true"|"on"|"yes" if file system is case
     *                                  sensitive, "false"|"off"|"no" when not.
     * @return void
     */
    public function setCaseSensitive($isCaseSensitive)
    {
        $this->fileset->setCaseSensitive($isCaseSensitive);
    }

    /**
     * Sets whether or not symbolic links should be followed.
     *
     * @param  boolean $followSymlinks whether or not symbolic links should be followed
     * @return void
     */
    public function setFollowSymlinks($followSymlinks)
    {
        $this->fileset->setExpandSymbolicLinks($followSymlinks);
    }

    /**
     * Indicates whether there are any selectors here.
     *
     * @return boolean Whether any selectors are in this container
     */
    public function hasSelectors()
    {
        return $this->fileset->hasSelectors();
    }

    /**
     * Gives the count of the number of selectors in this container
     *
     * @return int The number of selectors in this container
     */
    public function selectorCount()
    {
        return $this->fileset->selectorCount();
    }

    /**
     * Returns the set of selectors as an array.
     *
     * @param Project $p
     * @return array FileSelector[] An array of selectors in this container
     */
    public function getSelectors(Project $p)
    {
        return $this->fileset->getSelectors($p);
    }

    /**
     * Returns an enumerator for accessing the set of selectors.
     *
     * @return array an enumerator that goes through each of the selectors
     */
    public function selectorElements()
    {
        return $this->fileset->selectorElements();
    }

    /**
     * Add a new selector into this container.
     *
     * @param  FileSelector $selector the new selector to add
     * @return void
     */
    public function appendSelector(FileSelector $selector)
    {
        $this->fileset->appendSelector($selector);
    }

    /* Methods below all add specific selectors */

    /**
     * add a "Select" selector entry on the selector list
     * @return SelectSelector
     */
    public function addSelector(SelectSelector $selector)
    {
        return $this->fileset->addSelector($selector);
    }

    /**
     * add an "And" selector entry on the selector list
     * @return AndSelector
     */
    public function addAnd(AndSelector $selector)
    {
        return $this->fileset->addAnd($selector);
    }

    /**
     * add an "Or" selector entry on the selector list
     * @return OrSelector
     */
    public function addOr(OrSelector $selector)
    {
        return $this->fileset->addOr($selector);
    }

    /**
     * add a "Not" selector entry on the selector list
     * @return NotSelector
     */
    public function addNot(NotSelector $selector)
    {
        return $this->fileset->addNot($selector);
    }

    /**
     * add a "None" selector entry on the selector list
     * @return NoneSelector
     */
    public function addNone(NoneSelector $selector)
    {
        return $this->fileset->addNone($selector);
    }

    /**
     * add a majority selector entry on the selector list
     * @return MajoritySelector
     */
    public function addMajority(MajoritySelector $selector)
    {
        return $this->fileset->addMajority($selector);
    }

    /**
     * add a selector date entry on the selector list
     * @return DateSelector
     */
    public function addDate(DateSelector $selector)
    {
        return $this->fileset->addDate($selector);
    }

    /**
     * add a selector size entry on the selector list
     * @return SizeSelector
     */
    public function addSize(SizeSelector $selector)
    {
        return $this->fileset->addSize($selector);
    }

    /**
     * add a selector filename entry on the selector list
     * @return FilenameSelector
     */
    public function addFilename(FilenameSelector $selector)
    {
        return $this->fileset->addFilename($selector);
    }

    /**
     * add an extended selector entry on the selector list
     * @return ExtendSelector
     */
    public function addCustom(ExtendSelector $selector)
    {
        return $this->fileset->addCustom($selector);
    }

    /**
     * add a contains selector entry on the selector list
     */
    public function addContains(ContainsSelector $selector)
    {
        return $this->fileset->addContains($selector);
    }

    /**
     * add a present selector entry on the selector list
     */
    public function addPresent(PresentSelector $selector)
    {
        return $this->fileset->addPresent($selector);
    }

    /**
     * add a depth selector entry on the selector list
     */
    public function addDepth(DepthSelector $selector)
    {
        return $this->fileset->addDepth($selector);
    }

    /**
     * add a depends selector entry on the selector list
     */
    public function addDepend(DependSelector $selector)
    {
        return $this->fileset->addDepend($selector);
    }

    /**
     * add a executable selector entry on the selector list
     */
    public function addExecutable(ExecutableSelector $selector)
    {
        return $this->fileset->addExecutable($selector);
    }

    /**
     * add a readable selector entry on the selector list
     */
    public function addReadable(ReadableSelector $selector)
    {
        return $this->fileset->addReadable($selector);
    }

    /**
     * add a writable selector entry on the selector list
     */
    public function addWritable(WritableSelector $selector)
    {
        return $this->fileset->addWritable($selector);
    }

    /**
     * add a different selector entry on the selector list
     */
    public function addDifferent(DifferentSelector $selector)
    {
        return $this->fileset->addDifferent($selector);
    }

    /**
     * add a type selector entry on the selector list
     * @param TypeSelector $selector
     */
    public function addType(TypeSelector $selector)
    {
        return $this->fileset->addType($selector);
    }

    /**
     * add a contains selector entry on the selector list
     * @param ContainsRegexpSelector $selector
     */
    public function addContainsRegexp(ContainsRegexpSelector $selector)
    {
        return $this->fileset->addContainsRegexp($selector);
    }

    public function addSymlink(SymlinkSelector $selector)
    {
        return $this->fileset->addSymlink($selector);
    }

    /**
     * Accessor for the implict fileset.
     *
     * @return FileSet
     */
    final protected function getImplicitFileSet()
    {
        return $this->fileset;
    }
}
