using UnityEngine;
using UnityEngine.UI;
using UnityEngine.Networking;
using System.Collections;
using System.Collections.Generic;

public class TankHealth : NetworkBehaviour
{
    public float m_StartingHealth = 100f;          
    public Slider m_Slider;
    public Image m_FillImage;
    public Color m_FullHealthColor = Color.green;
    public Color m_ZeroHealthColor = Color.red;    
    public GameObject m_ExplosionPrefab;
    public GameObject UIPrefab;
    public GameObject canvas;

    private AudioSource m_ExplosionAudio;          
    private ParticleSystem m_ExplosionParticles;   
    private float m_CurrentHealth;  
    private bool m_Dead;
    private Vector3 startingPosition;
    private Quaternion startingRotation;
    [SyncVar] public int tankID;

    private void Awake()
    {
        m_ExplosionParticles = Instantiate(m_ExplosionPrefab).GetComponent<ParticleSystem>();
        m_ExplosionAudio = m_ExplosionParticles.GetComponent<AudioSource>();

        m_ExplosionParticles.gameObject.SetActive(false);

        canvas = Instantiate(UIPrefab, UIPrefab.transform.position, UIPrefab.transform.rotation) as GameObject;
        for(int i = 0;i < canvas.GetComponentsInChildren<Text>().Length;i++)
        {
            canvas.GetComponentsInChildren<Text>()[i].color = Color.white;
        }
        canvas.SetActive(false);
        
    }

    private void OnEnable()
    {
        


        m_Dead = false;

        //m_Slider.value = m_CurrentHealth;
        //m_FillImage.color = Color.Lerp(m_ZeroHealthColor, m_FullHealthColor, m_CurrentHealth / m_StartingHealth);
    }

    private void Start()
    {
        tankID = GetComponent<TankIdentity>().ID;
        if (tankID == 1)
        {
            m_StartingHealth = 1000f;
        }
        m_CurrentHealth = m_StartingHealth;
        m_Slider.maxValue = m_CurrentHealth;
        m_Slider.value = m_CurrentHealth;
        m_FillImage.color = Color.Lerp(m_ZeroHealthColor, m_FullHealthColor, m_CurrentHealth / m_StartingHealth);
    }
    void Update()
    {
        if(m_Dead && isLocalPlayer)
        {
            canvas.SetActive(true);
        }
    }

    public void TakeDamage(float amount)
    {
        if (!isServer)
        {
            return;
        }
        // Adjust the tank's current health, update the UI based on the new health and check whether or not the tank is dead.
        // Reduce current health by the amount of damage done.
        if (!m_Dead)
        {
            m_CurrentHealth -= amount;

            // Change the UI elements appropriately.
            RpcSetHealthUI(amount);
        }

        // If the current health is at or below zero and it has not yet been registered, call OnDeath.
        if (m_CurrentHealth <= 0f && !m_Dead)
        {
            RpcOnDeath();
        }
    }

    [ClientRpc]
    private void RpcSetHealthUI(float amount)
    {
        // Adjust the value and colour of the slider.
        // Set the slider's value appropriately.
        if (!isServer)
        {
            m_CurrentHealth -= amount;
        }
        m_Slider.value = m_CurrentHealth;
        // Interpolate the color of the bar between the choosen colours based on the current percentage of the starting health.
        m_FillImage.color = Color.Lerp(m_ZeroHealthColor, m_FullHealthColor, m_CurrentHealth / m_StartingHealth);
    }

    [ClientRpc]
    private void RpcOnDeath()
    {
        // Play the effects for the death of the tank and deactivate it.
        // Set the flag so that this function is only called once.
        m_Dead = true;

        // Move the instantiated explosion prefab to the tank's position and turn it on.
        m_ExplosionParticles.transform.position = transform.position + new Vector3(0f, 5f, 0f);
        m_ExplosionParticles.gameObject.SetActive(true);

        // Play the particle system of the tank exploding.
        m_ExplosionParticles.Play();

        // Play the tank explosion sound effect.
        m_ExplosionAudio.Play();

        // Turn the tank off.
        gameObject.transform.position = new Vector3(gameObject.transform.position.x, -5f, gameObject.transform.position.z);

        if(tankID == 1)
        {
            if (isLocalPlayer)
            {
                for (int i = 0; i < canvas.GetComponentsInChildren<Text>().Length; i++)
                {
                    canvas.GetComponentsInChildren<Text>()[i].text = "YOU LOSE";
                }
            }
            else
            {
                for (int i = 0; i < canvas.GetComponentsInChildren<Text>().Length; i++)
                {
                    canvas.GetComponentsInChildren<Text>()[i].text = "YOU WIN";
                }
                
            }
            canvas.SetActive(true);
        }
        else
        {
            NetworkLobbyHook.clientDeathCount.Add(gameObject);
            if (NetworkLobbyHook.clientDeathCount.Count == NetworkLobbyHook.totalPlayerCount - 1)
            {
                if (isLocalPlayer)
                {
                    for (int i = 0; i < canvas.GetComponentsInChildren<Text>().Length; i++)
                    {
                        canvas.GetComponentsInChildren<Text>()[i].text = "YOU LOSE";
                    }
                }
                else
                {
                    for (int i = 0; i < canvas.GetComponentsInChildren<Text>().Length; i++)
                    {
                        canvas.GetComponentsInChildren<Text>()[i].text = "YOU WIN";
                    }

                }
                canvas.SetActive(true);
            }
        }
    }
}