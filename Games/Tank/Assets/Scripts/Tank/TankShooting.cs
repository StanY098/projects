using UnityEngine;
using UnityEngine.UI;
using UnityEngine.Networking;

public class TankShooting : NetworkBehaviour
{
    public int m_PlayerNumber = 1;       
    public GameObject m_Shell;
    public Transform m_FireTransform;    
    public Slider m_AimSlider;           
    public AudioSource m_ShootingAudio;  
    public AudioClip m_ChargingClip;     
    public AudioClip m_FireClip;         
    public float m_MinLaunchForce = 15f; 
    public float m_MaxLaunchForce = 30f; 
    public float m_MaxChargeTime = 0.75f;

    private float m_CurrentLaunchForce;  
    private float m_ChargeSpeed;         
    private bool m_Fired;                


    private void OnEnable()
    {
        m_CurrentLaunchForce = m_MinLaunchForce;
        m_AimSlider.value = m_MinLaunchForce;
    }


    private void Start()
    {

        m_ChargeSpeed = (m_MaxLaunchForce - m_MinLaunchForce) / m_MaxChargeTime;
    }

    private void Update()
    {
        // Track the current state of the fire button and make decisions based on the current launch force.
        // The slider should have a default value of the minimum launch force.

        if (!isLocalPlayer)
        {
            return;
        }
        m_AimSlider.value = m_MinLaunchForce;

        // If the max force has been exceeded and the shell hasn't yet been launched...
        if (m_CurrentLaunchForce >= m_MaxLaunchForce && !m_Fired)
        {
            // ... use the max force and launch the shell.
            m_CurrentLaunchForce = m_MaxLaunchForce;
            CmdFire(m_CurrentLaunchForce);
            m_Fired = true;

        }
        // Otherwise, if the fire button has just started being pressed...
        else if (Input.GetButtonDown("Fire1"))
        {
            // ... reset the fired flag and reset the launch force.
            m_Fired = false;
            m_CurrentLaunchForce = m_MinLaunchForce;

            // Change the clip to the charging clip and start it playing.
            m_ShootingAudio.clip = m_ChargingClip;
            m_ShootingAudio.Play();
        }
        // Otherwise, if the fire button is being held and the shell hasn't been launched yet...
        else if (Input.GetButton("Fire1") && !m_Fired)
        {
            // Increment the launch force and update the slider.
            m_CurrentLaunchForce += m_ChargeSpeed * Time.deltaTime;

            m_AimSlider.value = m_CurrentLaunchForce;
        }
        // Otherwise, if the fire button is released and the shell hasn't been launched yet...
        else if (Input.GetButtonUp("Fire1") && !m_Fired)
        {
            // ... launch the shell.
            CmdFire(m_CurrentLaunchForce);
            m_Fired = true;

        }
    }

    [Command]
    private void CmdFire(float m_CurrentLaunchForce)
    {
        // Instantiate and launch the shell.
        // Set the fired flag so only Fire is only called once.
        m_Fired = true;

        // Create an instance of the shell and store a reference to it's rigidbody.
        GameObject shellInstance = Instantiate(m_Shell, m_FireTransform.position, m_FireTransform.rotation) as GameObject;
        shellInstance.GetComponent<Rigidbody>().velocity = m_CurrentLaunchForce * m_FireTransform.forward;
        
        // Change the clip to the firing clip and play it.
        m_ShootingAudio.clip = m_FireClip;
        m_ShootingAudio.Play();

        // Reset the launch force.  This is a precaution in case of missing button events.
        m_CurrentLaunchForce = m_MinLaunchForce;
        NetworkServer.Spawn(shellInstance);
    }
}