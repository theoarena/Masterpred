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

/**
 * Checks if a given file is valid JSON
 * <jsonvalidate file="path/file.json" />
 *
 * @author Suat Özgür
 * @package   phing.tasks.ext
 */
class JsonValidateTask extends Task
{

    private $file = null;

    /**
     * executes the ValidJson task
     */
    public function main()
    {

        if (is_null($this->getFile())) {
            $msg = "JsonValidate: file is not defined.";
            $this->log($msg, Project::MSG_ERR);
            throw new \BuildException($msg);
        }

        if (!file_exists($this->getFile()) || is_dir($this->getFile())) {
            $msg = "JsonValidate: file not found " . $this->getFile();
            $this->log($msg, Project::MSG_ERR);
            throw new \BuildException($msg);
        }

        $decoded = json_decode(file_get_contents($this->getFile()));
        if (is_null($decoded)) {
            $msg = "JsonValidate: decoding " . $this->getFile() . " failed.";
            $this->log($msg, Project::MSG_ERR);
            throw new \BuildException($msg);
        }
        $this->log($this->getFile() . " is valid JSON", Project::MSG_INFO);
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }
}

