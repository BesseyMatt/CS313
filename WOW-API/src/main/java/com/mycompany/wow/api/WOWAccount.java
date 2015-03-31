/**********************************
 * WOWAccount Class Definition
 **********************************/
package com.mycompany.wow.api;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.OneToMany;
import javax.persistence.Table;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlRootElement;
import javax.xml.bind.annotation.XmlType;

/**
 *
 * @author Matt Bessey
 */
@Entity
@Table(name="WOWAccount")
@XmlRootElement(name = "wowaccount")
@XmlType(propOrder={"accountId", "name", "link", "isActive", "characters"})
public class WOWAccount implements Serializable {
    
    @Id
    @GeneratedValue
    @Column(name="accountId")
    private int accountId;
    
    @Column(name="accountName")
    private String name;
    
    @Column(name="link")
    private String link;
    
    @Column(name="isActive")
    private boolean isActive;
    
    @OneToMany(mappedBy = "superAccount")
    private List<WOWCharacter> characters = new ArrayList<WOWCharacter>();

    @XmlElement
    public int getAccountId() {
        return accountId;
    }

    public void setAccountId(int id) {
        this.accountId = id;
    }

    @XmlElement
    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    @XmlElement
    public String getLink() {
        return link;
    }

    public void setLink(String link) {
        this.link = link;
    }

    @XmlElement
    public boolean getIsActive() {
        return isActive;
    }

    public void setIsActive(boolean isActive) {
        this.isActive = isActive;
    }
    
    @XmlElement
    public List<WOWCharacter> getCharacters() {
        return characters;
    }

    public void setCharacters(List<WOWCharacter> characters) {
        this.characters = characters;
    }
}
