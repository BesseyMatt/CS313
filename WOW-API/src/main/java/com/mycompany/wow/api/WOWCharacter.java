/**********************************
 * WOWCharacter Class Definition
 **********************************/
package com.mycompany.wow.api;

import java.io.Serializable;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
import javax.persistence.Table;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlRootElement;
import javax.xml.bind.annotation.XmlTransient;
import javax.xml.bind.annotation.XmlType;

/**
 *
 * @author Matt Bessey
 */
@Entity
@Table(name="WOWCharacter")
@XmlRootElement(name = "character")
@XmlType(propOrder={"characterId", "name", "race", "classType", "faction", "level", "isActive"})
public class WOWCharacter implements Serializable {
    
    @Id
    @GeneratedValue
    @Column(name="characterId")
    private int characterId;
    
    @Column(name="characterName")
    private String name;
    
    @Column(name="level")
    private int level;
    
    @Column(name="race")
    private String race;
    
    @Column(name="class")
    private String classType;
    
    @Column(name="faction")
    private String faction; 
    
    @Column(name="isActive")
    private Boolean isActive;
    
    @ManyToOne
    @JoinColumn(name="accountId")
    @XmlTransient
    private WOWAccount superAccount;
    
    public WOWCharacter() {
        
    }

    public WOWCharacter(String name, String race, String classType, String faction, int level, Boolean isActive, WOWAccount superAccount) {
        this.name = name;
        this.level = level;
        this.race = race;
        this.classType = classType;
        this.faction = faction;
        this.isActive = isActive;
        this.superAccount = superAccount;
    }

    @XmlElement
    public int getCharacterId() {
        return characterId;
    }

    public void setId(int id) {
        this.characterId = id;
    }

    @XmlElement
    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    @XmlElement
    public int getLevel() {
        return level;
    }

    public void setLevel(int level) {
        this.level = level;
    }
    
    @XmlElement
    public String getRace() {
        return race;
    }

    public void setRace(String race) {
        this.race = race;
    }

    @XmlElement
    public String getClassType() {
        return classType;
    }

    public void setClassType(String classType) {
        this.classType = classType;
    }

    @XmlElement
    public String getFaction() {
        return faction;
    }

    public void setFaction(String faction) {
        this.faction = faction;
    }

    @XmlElement
    public Boolean getIsActive() {
        return isActive;
    }

    public void setIsActive(Boolean isActive) {
        this.isActive = isActive;
    }
    
    private WOWAccount getSuperAccount() {
        return this.superAccount;
    }
}
