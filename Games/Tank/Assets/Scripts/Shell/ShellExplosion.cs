using UnityEngine;
using UnityEngine.Networking;

public class ShellExplosion : NetworkBehaviour
{
    public LayerMask m_TankMask;
    public GameObject m_explosion;
    ParticleSystem m_ExplosionParticles;       
    AudioSource m_ExplosionAudio;
    public float m_MaxDamage = 100f;                  
    public float m_ExplosionForce = 1000f;            
    public float m_MaxLifeTime = 10f;                  
    public float m_ExplosionRadius = 5f;
    float count;
    GameObject explosion;

    private void Start()
    {
        count = 0;
        
    }

    [ServerCallback]
    public void Update()
    {
        //explosion.transform.position = transform.position;
        count += Time.deltaTime;
        if (count > m_MaxLifeTime)
        {
            NetworkServer.Destroy(gameObject);
        }
    }
    private void OnTriggerEnter(Collider other)
    {
        CmdExplosion();
        
        // Find all the tanks in an area around the shell and damage them.
        // Collect all the colliders in a sphere from the shell's current position to a radius of the explosion radius.
        Collider[] colliders = Physics.OverlapSphere(transform.position, m_ExplosionRadius, m_TankMask);
        // Unparent the particles from the shell.
        //m_ExplosionParticles.transform.parent = null;

        // Play the explosion sound effect.

        // Go through all the colliders...
        for (int i = 0; i < colliders.Length; i++)
        {
            // ... and find their rigidbody.
            Rigidbody targetRigidbody = colliders[i].GetComponent<Rigidbody>();

            // If they don't have a rigidbody, go on to the next collider.
            if (!targetRigidbody)
                continue;

            // Add an explosion force.
            //targetRigidbody.AddExplosionForce(m_ExplosionForce, transform.position, m_ExplosionRadius);

            // Find the TankHealth script associated with the rigidbody.
            TankHealth targetHealth = targetRigidbody.GetComponent<TankHealth>();

            // If there is no TankHealth script attached to the gameobject, go on to the next collider.
            if (!targetHealth || !isServer)
                continue;

            // Calculate the amount of damage the target should take based on it's distance from the shell.
            float damage = CalculateDamage(targetRigidbody.position);

            // Deal this damage to the tank.
            targetHealth.TakeDamage(damage);
        }

        

        // Once the particles have finished, destroy the gameobject they are on.
        //Destroy(m_ExplosionParticles.gameObject, m_ExplosionParticles.duration);

        // Destroy the shell.
        NetworkServer.Destroy(gameObject);

    }

    [Command]
    public void CmdExplosion()
    {
        explosion = Instantiate(m_explosion, transform.position, transform.rotation) as GameObject;
        NetworkServer.Spawn(explosion);
        
    }

    private float CalculateDamage(Vector3 targetPosition)
    {
        // Calculate the amount of damage a target should take based on it's position.
        // Create a vector from the shell to the target.
        Vector3 explosionToTarget = targetPosition - transform.position;

        // Calculate the distance from the shell to the target.
        float explosionDistance = explosionToTarget.magnitude;

        // Calculate the proportion of the maximum distance (the explosionRadius) the target is away.
        float relativeDistance = (m_ExplosionRadius - explosionDistance) / m_ExplosionRadius;

        // Calculate damage as this proportion of the maximum possible damage.
        float damage = relativeDistance * m_MaxDamage;

        // Make sure that the minimum damage is always 0.
        damage = Mathf.Max(0f, damage);

        return damage;
    }
}