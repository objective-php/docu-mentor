<?php

namespace ObjectivePHP\DocuMentor\Config;

use ObjectivePHP\Config\Directive\AbstractComplexDirective;

class ExampleConfig extends AbstractComplexDirective
{
    const KEY = 'example';

    /**
     * @var string
     */
    protected $key = self::KEY;

    /**
     * Array value
     *
     * An example with an array for value
     *
     * @config-attribute
     *
     * @config-example-value        array( 'first_value',
     * @config-example-value        'second_value' )
     *
     * @var array
     */
    protected $someArray;

    /**
     * An Object User
     *
     * @config-attribute     hash
     *
     * @config-example-value {
     * @config-example-value "user_name": "Mocks username",
     * @config-example-value "brother_name": "Mocks brothername"
     * @config-example-value }
     *
     * @var User
     */
    protected $mockUser;

    /**
     * Two lines String
     *
     * Take attention where the quotes are placed
     *
     * @config-attribute
     * @config-example-value  Start of a string
     * @config-example-value  end of a string
     * @var string
     */
    protected $defaultTargetPath = '/';

    /**
     * @config-attribute
     *
     * @var string
     */
    protected $logoutTargetPath = '/';

    /**
     * @config-attribute
     *
     * @var string
     */
    protected $profileAssociationPath = '/connect/profile-association';

    /**
     * @config-attribute
     *
     * @config-example-value 'connect.profile-association.service'
     *
     * @var string
     */
    protected $profileAssociationService;

    /**
     * @config-attribute
     *
     * @config-example-value 'http://my-
     * @config-example-value site.com'
     *
     * @var string
     */
    protected $entityId;

    /**
     * @config-attribute
     *
     * @config-example-value 'http://idp.com'
     *
     * @var string
     */
    protected $idpEntityId;

    /**
     * @config-attribute
     *
     * @config-example-value 'My SP name'
     *
     * @var string Entity name (replaced by entityId if not set)
     */
    protected $name;

    /**
     * @config-attribute
     *
     * @var string
     */
    protected $samlMetadataBasedir = 'app/config/Saml/metadata';

    /**
     * @config-attribute
     *
     * @var string
     */
    protected $spMetadataFile = 'sp.xml';

    /**
     * @config-attribute
     *
     * @var string
     */
    protected $idpMetadataFile;

    /**
     * @config-attribute
     *
     * @var string
     */
    protected $idpMetadataFileTarget = '/idp.xml';

    /**
     * @config-attribute
     *
     * @var string
     */
    protected $privateKeyFilePath = 'app/config/key/sp.pem';

    /**
     * @config-attribute
     *
     * @var string
     */
    protected $adminPathInfo = '/connect/admin';

    /**
     * Get client status
     *
     * @return bool
     */
    public function enable(): bool
    {
        return $this->enable;
    }

    /**
     * Set enable
     *
     * @param bool $enable
     *
     * @return $this
     */
    public function setEnable(bool $enable)
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * Get MockUser
     *
     * @return User
     */
    public function getMockUser(): User
    {
        return $this->mockUser;
    }

    /**
     * Set MockUser
     *
     * @param array $mockUser
     *
     * @return $this
     */
    public function setMockUser(array $mockUser)
    {
        $this->mockUser = new User($mockUser);

        return $this;
    }

    /**
     * Get DefaultTargetPath
     *
     * @return string
     */
    public function getDefaultTargetPath(): string
    {
        return $this->defaultTargetPath;
    }

    /**
     * Set DefaultTargetPath
     *
     * @param string $defaultTargetPath
     *
     * @return $this
     */
    public function setDefaultTargetPath(string $defaultTargetPath)
    {
        $this->defaultTargetPath = $defaultTargetPath;

        return $this;
    }

    /**
     * Get LogoutTargetPath
     *
     * @return string
     */
    public function getLogoutTargetPath(): string
    {
        return $this->logoutTargetPath;
    }

    /**
     * Set LogoutTargetPath
     *
     * @param string $logoutTargetPath
     *
     * @return $this
     */
    public function setLogoutTargetPath(string $logoutTargetPath)
    {
        $this->logoutTargetPath = $logoutTargetPath;

        return $this;
    }

    /**
     * Get ProfileAssociationPath
     *
     * @return string
     */
    public function getProfileAssociationPath(): string
    {
        return $this->profileAssociationPath;
    }

    /**
     * Set ProfileAssociationPath
     *
     * @param string $profileAssociationPath
     *
     * @return $this
     */
    public function setProfileAssociationPath(string $profileAssociationPath)
    {
        $this->profileAssociationPath = $profileAssociationPath;

        return $this;
    }

    /**
     * Get ProfileAssociationService
     *
     * @return string
     */
    public function getProfileAssociationService(): string
    {
        return $this->profileAssociationService;
    }

    /**
     * Set ProfileAssociationService
     *
     * @param string $profileAssociationService
     *
     * @return $this
     */
    public function setProfileAssociationService(string $profileAssociationService)
    {
        $this->profileAssociationService = $profileAssociationService;

        return $this;
    }

    /**
     * Get EntityId
     *
     * @return string
     */
    public function getEntityId(): string
    {
        return $this->entityId;
    }

    /**
     * Set EntityId
     *
     * @param string $entityId
     *
     * @return $this
     */
    public function setEntityId(string $entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get IdpEntityId
     *
     * @return string
     */
    public function getIdpEntityId(): string
    {
        return $this->idpEntityId;
    }

    /**
     * Set IdpEntityId
     *
     * @param string $idpEntityId
     *
     * @return $this
     */
    public function setIdpEntityId(string $idpEntityId)
    {
        $this->idpEntityId = $idpEntityId;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set Name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get SamlMetadataBasedir
     *
     * @return string
     */
    public function getSamlMetadataBasedir(): string
    {
        return $this->samlMetadataBasedir;
    }

    /**
     * Set SamlMetadataBasedir
     *
     * @param string $samlMetadataBasedir
     *
     * @return $this
     */
    public function setSamlMetadataBasedir(string $samlMetadataBasedir)
    {
        $this->samlMetadataBasedir = $samlMetadataBasedir;

        return $this;
    }

    /**
     * Get SpMetadataFile
     *
     * @return string
     */
    public function getSpMetadataFile(): string
    {
        return $this->spMetadataFile;
    }

    /**
     * Set SpMetadataFile
     *
     * @param string $spMetadataFile
     *
     * @return $this
     */
    public function setSpMetadataFile(string $spMetadataFile)
    {
        $this->spMetadataFile = $spMetadataFile;

        return $this;
    }

    /**
     * Get IdpMetadataFile
     *
     * @return string
     */
    public function getIdpMetadataFile(): string
    {
        return $this->idpMetadataFile;
    }

    /**
     * Set IdpMetadataFile
     *
     * @param string $idpMetadataFile
     *
     * @return $this
     */
    public function setIdpMetadataFile(string $idpMetadataFile)
    {
        $this->idpMetadataFile = $idpMetadataFile;

        return $this;
    }

    /**
     * Get IdpMetadataFileTarget
     *
     * @return string
     */
    public function getIdpMetadataFileTarget(): string
    {
        return $this->idpMetadataFileTarget;
    }

    /**
     * Set IdpMetadataFileTarget
     *
     * @param string $idpMetadataFileTarget
     *
     * @return $this
     */
    public function setIdpMetadataFileTarget(string $idpMetadataFileTarget)
    {
        $this->idpMetadataFileTarget = $idpMetadataFileTarget;

        return $this;
    }

    /**
     * Get PrivateKeyFilePath
     *
     * @return string
     */
    public function getPrivateKeyFilePath(): string
    {
        return $this->privateKeyFilePath;
    }

    /**
     * Set PrivateKeyFilePath
     *
     * @param string $privateKeyFilePath
     *
     * @return $this
     */
    public function setPrivateKeyFilePath(string $privateKeyFilePath)
    {
        $this->privateKeyFilePath = $privateKeyFilePath;

        return $this;
    }

    /**
     * Get AdminPathInfo
     *
     * @return string
     */
    public function getAdminPathInfo(): string
    {
        return $this->adminPathInfo;
    }

    /**
     * Set AdminPathInfo
     *
     * @param string $adminPathInfo
     *
     * @return $this
     */
    public function setAdminPathInfo(string $adminPathInfo)
    {
        $this->adminPathInfo = $adminPathInfo;

        return $this;
    }
}
